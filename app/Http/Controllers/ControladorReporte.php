<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ficha;
use App\Models\Informe;
use App\Models\TipoFicha;

class ControladorReporte extends Controller
{
    public function Reporte(Request $request)
    {
        // Validación de las fechas
        if ($request->has('fecha_inicio') && $request->has('fecha_fin')) {
            if ($request->fecha_inicio > $request->fecha_fin) {
                return back()->with('error', 'La fecha de inicio no puede ser mayor que la fecha de fin.');
            }
        }
    
        // Obtener todos los tipos de ficha
        $tiposFicha = TipoFicha::all();
        $fichas = Ficha::with('activos')->get(); // Incluye los activos asociados a cada ficha
    
        $queryFichas = Ficha::query();
        $queryInformes = Informe::query();
    
        // Filtro por fecha
        if ($request->has('fecha_inicio') && $request->has('fecha_fin') && $request->fecha_inicio <= $request->fecha_fin) {
            $fechaInicio = $request->fecha_inicio;
            $fechaFin = $request->fecha_fin . ' 23:59:59'; // Incluimos el final del día
            
            // Aplicamos filtro por fecha a fichas
            $queryFichas->whereBetween('created_at', [$fechaInicio, $fechaFin]);
    
            // Aplicamos filtro por fecha a informes
            $queryInformes->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        }
    
        // Filtro por tipo de ficha
        if ($request->has('filtro') && $request->filtro != '') {
            // Si el filtro es "Informe tecnico", solo buscamos en informes
            if ($request->filtro == 'Informe tecnico') {
                $queryFichas->whereNull('id_tipo');  // Excluye las fichas que tienen tipo
                $queryInformes->whereNotNull('id_activo');  // Asegura que se seleccionen solo informes técnicos
            } else {
                // Si el filtro es un tipo de ficha específico, filtramos las fichas por tipo
                $queryFichas->whereHas('tipo', function ($q) use ($request) {
                    $q->where('nombre', $request->filtro);
                });
                $queryInformes->whereNull('id_activo');  // Excluye informes técnicos cuando no es el filtro
            }
        }
    
        // Obtener los resultados filtrados
        $fichas = $queryFichas->get();
        $informes = $queryInformes->get();
    
        return view('Reporte/Reporte', compact('fichas', 'informes', 'tiposFicha'));
    }
    
    public function getDatosReporte(Request $request)
    {
        // Similar a lo que ya haces en el método Reporte, pero solo obtienes las fichas
        $fichas = Ficha::with('activos')->get();
        return response()->json($fichas);
    }
    
        
}
