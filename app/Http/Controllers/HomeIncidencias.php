<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Carbon\Carbon;
use App\Models\Incidencia;
use App\Models\sede;
use App\Models\Persona;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class HomeIncidencias extends Controller
{
    public function Inicio()
    {
        $sedes = sede::all();
        $areas = Area::all();
        return view('Incidencias/HomeIncidencias', compact('sedes', 'areas'));
    }

    public function registrarIncidencia(Request $request)
    {
        $request->validate([]);

        Incidencia::Create([
            'nombre' => $request->nombre,
            'id_sede' => $request->id_sede,
            'id_area' => $request->id_area,
            'detalle' => $request->detalle,
            'fecha_ingreso' => Carbon::now()->toDateString(),
            'estado' => 'abierto' ,// Estado cuando se registra la incidencia
            'visto' => false

        ]);

        return redirect()->route('ListaIncidencia');
    }

    public function marcarVistoYVer($id)
    {
        $incidencia = Incidencia::findOrFail($id);
        
        // Marcar como vista
        $incidencia->visto = true;
        $incidencia->save();

        // Redirigir a la vista de la incidencia
        return redirect()->route('ListaIncidencia', $id);
    }

    public function Ver(Request $request)
    {
        $estado = $request->estado; // Obtener el filtro de estado de la solicitud
    
        // Filtrar las incidencias según el estado, si se ha seleccionado alguno
        if ($estado) {
            $incidencias = Incidencia::where('estado', $estado)->get();
        } else {
            $incidencias = Incidencia::all(); // Obtener todas las incidencias si no se filtra por estado
        }
    
        return view('Incidencias/VerIncidencias', compact('incidencias'));
    }
    

    // Actualiza el estado de la incidencia
    public function actualizarEstado(Request $request, $id)
    {
        $incidencia = Incidencia::find($id);
        $incidencia->estado = $request->estado;
        
        // Si el estado cambia a "en proceso", actualiza el campo `updated_at`
        if ($request->estado === 'en proceso') {
            $incidencia->updated_at = Carbon::now();
        }

        // Si el estado cambia a "cerrado", actualiza `fecha_termino`
        if ($request->estado === 'cerrado') {
            $incidencia->fecha_termino = Carbon::now();
        }

        $incidencia->save();

        return response()->json(['success' => true]);
    }

    // Resuelve la incidencia y actualiza el estado
    public function resolverIncidencia(Request $request, $id)
    {
        $incidencia = Incidencia::find($id);

        // Si el procedimiento está vacío, cambia el estado a 'en proceso', pero no lo cierra aún
        if (empty($request->procedimiento)) {
            $incidencia->estado = 'en proceso'; // Estado intermedio
            $incidencia->updated_at = Carbon::now(); // Actualiza el `updated_at`
        } else {
            // Si el procedimiento está lleno, se marca como cerrado
            $incidencia->estado = 'cerrado'; // Estado finalizado
            $incidencia->fecha_termino = Carbon::now(); // Actualiza la fecha de terminación
        }

        // Actualiza el procedimiento y el personal encargado
        $incidencia->procedimiento = $request->procedimiento;
        $incidencia->id_personal = $request->personal_encargado;
        $incidencia->save();

        return response()->json(['success' => true]);
    }

    // Obtiene los detalles de la incidencia
    public function obtenerIncidencia($id)
    {
        $incidencia = Incidencia::with('personalEncargado')->find($id);
    
        if (!$incidencia) {
            return response()->json(['error' => 'Incidencia no encontrada'], 404);
        }
    
        $personalNombreApellido = $incidencia->personalEncargado
            ? $incidencia->personalEncargado->nombre . ' ' . $incidencia->personalEncargado->apellido
            : 'No asignado';
    
        return response()->json([
            'personal_encargado' => $personalNombreApellido
        ]);
    }
}
