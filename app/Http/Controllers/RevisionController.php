<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Articulo;
use App\Models\Bitacora;
use App\Models\Empleado;
use App\Models\MovimientoArticulo;
use App\Models\Periodo;
use App\Models\Resguardo;
use App\Models\ResguardoArticulo;
use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RevisionController extends Controller
{
    public function periodos()
    {
        $periodos = Periodo::withCount('resguardos')->orderByDesc('Id_Periodo')->paginate(15);

        return view('periodos.index', compact('periodos'));
    }

    public function crearPeriodo()
    {
        return view('periodos.create');
    }

    public function guardarPeriodo(Request $r)
    {
        $d = $r->validate(['Nombre' => 'required|string|max:50', 'Fecha_Inicio' => 'required|date']);
        Periodo::create($d + ['Estado' => 'Abierto', 'status' => 'activo', 'Estatus' => 'Activo']);

        return redirect()->route('revision.periodos')->with('ok', 'Periodo creado correctamente.');
    }

    public function seleccionar($periodo)
    {
        $periodo = Periodo::findOrFail($periodo);
        abort_if($periodo->Estado === 'Cerrado', 403, 'El periodo está cerrado.');
        $ubicaciones = Ubicacion::where('status', 'activo')->orderBy('Edificio')->orderBy('Nombre')->get();
        $empleados = Empleado::where('Estatus', 'Activo')->orderBy('Nombre')->get();

        return view('revision.select', compact('periodo', 'ubicaciones', 'empleados'));
    }

    public function iniciar(Request $r, $periodo)
    {
        $periodo = Periodo::findOrFail($periodo);
        abort_if($periodo->Estado === 'Cerrado', 403, 'El periodo está cerrado.');
        $d = $r->validate(['FkId_Ubicacion' => 'required|exists:ubicaciones,Id_Ubicacion', 'FkId_Empleado' => 'required|exists:empleados,Id_Empleado']);

        $existente = Resguardo::where('FkId_Periodo', $periodo->Id_Periodo)
            ->where('FkId_Ubicacion', $d['FkId_Ubicacion'])
            ->first();

        if ($existente) {
            return redirect()->route('revision.scan', $existente)->with('info', 'Ya existe un resguardo para esta ubicación en el periodo actual.');
        }

        $res = Resguardo::create($d + ['FkId_Periodo' => $periodo->Id_Periodo, 'FkId_Usuario_Revisor' => Auth::id(), 'Fecha_Firma' => now()->toDateString()]);
        $articulos = Articulo::where('FkId_Ubicacion', $d['FkId_Ubicacion'])->where('status', 'activo')->get();

        foreach ($articulos as $a) {
            ResguardoArticulo::firstOrCreate(
                ['FkId_Resguardo' => $res->Id_Resguardo, 'FkId_Articulo' => $a->Id_Articulo],
                ['FkId_Ubicacion' => $a->FkId_Ubicacion]
            );
        }

        return redirect()->route('revision.scan', $res);
    }

    public function scan(Resguardo $resguardo)
    {
        $resguardo->load(['periodo', 'empleado', 'ubicacion']);
        abort_if($resguardo->estaBloqueado(), 423, 'La revisión está cerrada.');

        $items = $resguardo->articulos()->with(['articulo.modelo', 'articulo.marca', 'articulo.ubicacion'])->orderBy('Revisado')->get();

        return view('revision.scan', compact('resguardo', 'items'));
    }

    public function buscar(Request $r, Resguardo $resguardo)
    {
        $r->validate(['codigo' => 'required|string|max:120']);
        $codigo = trim((string) $r->codigo);

        if ($resguardo->estaBloqueado()) {
            return response()->json([
                'ok' => false,
                'type' => 'blocked',
                'message' => 'El resguardo o el periodo están cerrados; no se puede seguir revisando.',
            ], 423);
        }

        $a = Articulo::with(['modelo', 'marca', 'ubicacion'])
            ->where('Codigo_Barras', $codigo)
            ->orWhere('N_Serie', $codigo)
            ->first();

        if (! $a) {
            return response()->json(['ok' => false, 'type' => 'not_found', 'message' => 'Artículo no encontrado.'], 404);
        }

        $activo = ($a->status ?? null) === 'activo' || ($a->Estatus ?? null) === 'Activo';
        if (! $activo || ($a->Tipo_Articulo ?? null) === 'Baja') {
            return response()->json([
                'ok' => false,
                'type' => 'not_expected',
                'article' => $this->articleJson($a),
                'message' => 'El artículo no está activo o no corresponde al proceso de revisión.',
            ]);
        }

        $expected = $resguardo->articulos()->where('FkId_Articulo', $a->Id_Articulo)->first();

        if (! $expected) {
            if ((int) $a->FkId_Ubicacion !== (int) $resguardo->FkId_Ubicacion) {
                return response()->json([
                    'ok' => false,
                    'type' => 'wrong_location',
                    'article' => $this->articleJson($a),
                    'actual_location' => $a->ubicacion?->Nombre ?? 'Sin ubicación',
                    'expected_location' => $resguardo->ubicacion?->Nombre ?? 'Ubicación esperada',
                    'message' => 'El artículo está registrado en otra ubicación y puede reasignarse al resguardo actual.',
                ]);
            }

            return response()->json([
                'ok' => false,
                'type' => 'not_expected',
                'article' => $this->articleJson($a),
                'message' => 'El artículo no pertenece a la carga esperada de esta ubicación.',
            ]);
        }

        if ($expected->Revisado) {
            return response()->json([
                'ok' => true,
                'type' => 'already_reviewed',
                'article' => $this->articleJson($a),
                'message' => 'Este artículo ya había sido revisado.',
            ]);
        }

        if ((int) $a->FkId_Ubicacion !== (int) $resguardo->FkId_Ubicacion) {
            return response()->json([
                'ok' => false,
                'type' => 'wrong_location',
                'article' => $this->articleJson($a),
                'actual_location' => $a->ubicacion?->Nombre ?? 'Sin ubicación',
                'expected_location' => $resguardo->ubicacion?->Nombre ?? 'Ubicación esperada',
                'message' => 'Artículo encontrado, pero está registrado en otra ubicación.',
            ]);
        }

        $expected->update(['Revisado' => true, 'Fecha_Revision' => now()]);
        $a->update(['Revisado' => true]);

        return response()->json([
            'ok' => true,
            'type' => 'reviewed',
            'article' => $this->articleJson($a),
            'message' => 'Artículo revisado correctamente.',
        ]);
    }

    private function articleJson(Articulo $a): array
    {
        $url = null;
        $image = $a->modelo?->URL_Imagen ?? $a->URL_Imagen;

        if ($image) {
            $url = Storage::disk('public')->url($image);
        }

        return [
            'id' => $a->Id_Articulo,
            'codigo' => $a->Codigo_Barras,
            'serie' => $a->N_Serie,
            'descripcion' => $a->Descripcion,
            'modelo' => $a->modelo?->Nombre,
            'marca' => $a->marca?->Nombre,
            'imagen' => $url,
        ];
    }

    public function reasignar(Request $r, Resguardo $resguardo, Articulo $articulo)
    {
        $r->validate(['confirmacion' => 'accepted']);

        if ($resguardo->estaBloqueado()) {
            return response()->json([
                'ok' => false,
                'type' => 'blocked',
                'message' => 'El resguardo o el periodo están cerrados y no se puede reasignar.',
            ], 423);
        }

        $origen = $articulo->FkId_Ubicacion;

        DB::transaction(function () use ($resguardo, $articulo, $origen) {
            $articulo->update(['FkId_Ubicacion' => $resguardo->FkId_Ubicacion]);

            $item = ResguardoArticulo::firstOrCreate(
                ['FkId_Resguardo' => $resguardo->Id_Resguardo, 'FkId_Articulo' => $articulo->Id_Articulo],
                ['FkId_Ubicacion' => $resguardo->FkId_Ubicacion, 'Revisado' => true, 'Fecha_Revision' => now(), 'Comentarios' => 'Ubicación reasignada durante revisión']
            );

            $item->update([
                'FkId_Ubicacion' => $resguardo->FkId_Ubicacion,
                'Revisado' => true,
                'Fecha_Revision' => now(),
                'Comentarios' => 'Ubicación reasignada durante revisión',
            ]);

            MovimientoArticulo::create([
                'FkId_Articulo' => $articulo->Id_Articulo,
                'FkId_Ubicacion_Origen' => $origen,
                'FkId_Ubicacion_Destino' => $resguardo->FkId_Ubicacion,
                'FkId_Resguardo' => $resguardo->Id_Resguardo,
                'FkId_Usuario' => Auth::id(),
                'Fecha' => now(),
                'Motivo' => 'Reasignación por revisión fuera de ubicación.',
            ]);

            $this->registrarBitacora('reasignacion', $articulo->Id_Articulo, 'Artículo', 'Reasignación por revisión fuera de ubicación.');
        });

        return response()->json(['ok' => true, 'message' => 'Ubicación reasignada y artículo marcado como revisado.']);
    }

    public function reabrir(Request $r, Resguardo $resguardo)
    {
        $r->validate([
            'motivo' => 'required|string|min:10',
            'password' => 'required|string',
        ]);

        $usuario = Auth::user();
        if (! $usuario || $usuario->rol?->Nombre !== 'Administrador' || ! Hash::check($r->password, $usuario->Password_Hash)) {
            abort(403, 'La autorización del administrador no coincide.');
        }

        DB::transaction(function () use ($resguardo, $r) {
            $resguardo->update([
                'Cerrado' => false,
                'Fecha_Cierre' => null,
                'Observaciones' => null,
            ]);

            if ($resguardo->periodo) {
                $resguardo->periodo->update([
                    'Estado' => 'Abierto',
                    'Fecha_Cierre' => null,
                ]);
            }

            $this->registrarBitacora(
                'reapertura',
                $resguardo->Id_Resguardo,
                'Resguardo',
                'Resguardo reabierto por autorización del administrador. Motivo: '.$r->motivo,
            );
        });

        return redirect()->route('revision.close', $resguardo)->with('ok', 'Resguardo reabierto correctamente.');
    }

    public function reabrirPeriodo(Request $r, Periodo $periodo)
    {
        $r->validate([
            'motivo' => 'required|string|min:10',
            'password' => 'required|string',
        ]);

        $usuario = Auth::user();
        if (! $usuario || $usuario->rol?->Nombre !== 'Administrador' || ! Hash::check($r->password, $usuario->Password_Hash)) {
            abort(403, 'La autorización del administrador no coincide.');
        }

        DB::transaction(function () use ($periodo, $r) {
            $periodo->update([
                'Estado' => 'Abierto',
                'Fecha_Cierre' => null,
            ]);

            $this->registrarBitacora(
                'reapertura_periodo',
                $periodo->Id_Periodo,
                'Periodo',
                'Periodo reabierto por autorización del administrador. Motivo: '.$r->motivo,
            );
        });

        return redirect()->route('revision.periodos')->with('ok', 'Periodo reabierto correctamente.');
    }

    public function cierre(Resguardo $resguardo)
    {
        $resguardo->load(['periodo', 'empleado', 'ubicacion']);
        $items = $resguardo->articulos()->with(['articulo.modelo', 'articulo.ubicacion'])->get();

        return view('revision.close', compact('resguardo', 'items'));
    }

    public function cerrarResguardo(Request $r, Resguardo $resguardo)
    {
        $r->validate(['Observaciones' => 'nullable|string|max:500']);
        abort_if($resguardo->estaBloqueado(), 423, 'No se puede cerrar un resguardo dentro de un periodo bloqueado.');

        $resguardo->update(['Cerrado' => true, 'Fecha_Cierre' => now(), 'Observaciones' => $r->Observaciones]);
        $this->registrarBitacora('cierre', $resguardo->Id_Resguardo, 'Resguardo', 'Cierre del resguardo con observaciones: '.$r->Observaciones);

        return redirect()->route('resguardo.print', $resguardo)->with('ok', 'Resguardo cerrado correctamente.');
    }

    public function imprimir(Resguardo $resguardo)
    {
        $resguardo->load(['periodo', 'empleado.area', 'empleado.puesto', 'ubicacion', 'articulos.articulo.modelo', 'articulos.articulo.ubicacion']);

        return view('resguardos.print', compact('resguardo'));
    }

    public function cerrarPeriodo(Request $r, Periodo $periodo)
    {
        abort_unless(Auth::user()?->rol?->Nombre === 'Administrador', 403, 'Solo el Administrador puede cerrar periodos.');
        abort_if($periodo->Estado === 'Cerrado', 403, 'El periodo ya está cerrado.');
        $pendientes = $periodo->resguardos()->where('Cerrado', false)->count();
        if ($pendientes > 0) {
            return back()->withErrors(['clave' => 'No se puede cerrar: todavía hay resguardos abiertos.']);
        }

        $periodo->update(['Estado' => 'Cerrado', 'Fecha_Cierre' => now()->toDateString()]);
        $this->registrarBitacora('cierre_periodo', $periodo->Id_Periodo, 'Periodo', 'Periodo cerrado por el administrador.');

        return redirect()->route('revision.periodos')->with('ok', 'Periodo cerrado y bloqueado.');
    }

    public function historico(Request $r)
    {
        $resguardos = Resguardo::with(['periodo', 'empleado', 'ubicacion'])
            ->when($r->ubicacion, fn ($q) => $q->where('FkId_Ubicacion', $r->ubicacion))
            ->when($r->empleado, fn ($q) => $q->where('FkId_Empleado', $r->empleado))
            ->when($r->area, fn ($q) => $q->whereHas('empleado', fn ($q) => $q->where('FkId_Area', $r->area)))
            ->orderByDesc('Id_Resguardo')
            ->paginate(20)
            ->withQueryString();
        $ubicaciones = Ubicacion::orderBy('Nombre')->get();
        $empleados = Empleado::orderBy('Nombre')->get();
        $areas = Area::orderBy('Nombre')->get();

        return view('revision.history', compact('resguardos', 'ubicaciones', 'empleados', 'areas'));
    }

    private function registrarBitacora(string $accion, int $idEntidad, string $entidad, string $detalle): void
    {
        Bitacora::create([
            'FkId_Usuario' => Auth::id(),
            'Accion' => $accion,
            'Entidad' => $entidad,
            'Id_Entidad' => $idEntidad,
            'Detalle' => $detalle,
            'Fecha' => now(),
        ]);
    }
}
