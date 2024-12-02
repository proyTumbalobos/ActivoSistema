<?php

namespace App\Http\Controllers;

use App\Models\activo;
use Illuminate\Http\Request;
use App\Models\Ficha;
use App\Models\Informe;
use App\Models\Incidencia;
use App\Models\Area;
use App\Models\CategoriaActivo;

class PrincipalControlador extends Controller
{

    public function PanelControl()
    {
        // Obtener las estadísticas de las fichas
        $fichasAsignadas = Ficha::where('id_tipo', 1)->count(); // Asignadas
        $fichasDevueltas = Ficha::where('id_tipo', 2)->count(); // Devueltas
        $fichasPrestadas = Ficha::where('id_tipo', 3)->count(); // Prestadas

        // Obtener las estadísticas de los informes
        $informesTecnicos = Informe::count();

        

        // PARA GRAFICO DE BARRA
        $areas = Area::all();

        // Preparar los datos para el gráfico de barras
        $incidenciasPorArea = [];
        foreach ($areas as $area) {
            // Contar las incidencias por estado para cada área
            $abiertas = Incidencia::where('id_area', $area->id)->where('estado', 'abierto')->count();
            $enProceso = Incidencia::where('id_area', $area->id)->where('estado', 'en proceso')->count();
            $cerradas = Incidencia::where('id_area', $area->id)->where('estado', 'cerrado')->count();

            // Almacenar los datos para cada área
            $incidenciasPorArea[] = [
                'area' => $area->nombre,
                'abiertas' => $abiertas,
                'enProceso' => $enProceso,
                'cerradas' => $cerradas
            ];
        }

        // Convertir a array para usar en la vista
        $incidenciasPorArea = collect($incidenciasPorArea);



        // PARA GRAFICO PASTEL
        $categorias = CategoriaActivo::all();

        // Preparar los datos para el gráfico de pastel
        $activosPorEstado  = [];
        foreach ($categorias as $categoria) {
            // Contar la cantidad de activos por estado para cada categoría
            $totalOperativos = Activo::where('estado', 'activo')->count();
            $totalNoOperativos = Activo::where('estado', 'no activo')->count();
            $totalMantenimiento = Activo::where('estado', 'mantenimiento')->count();

            $activosPorEstado = [
                'Operativos' => $totalOperativos,
                'No Operativos' => $totalNoOperativos,
                'Mantenimiento' => $totalMantenimiento
            ];

        }
        
        $activosPorEstado  = collect($activosPorEstado );



        // PARA BARRA HORIZONTAL
        $activos = activo::all();


        $activos = Activo::orderBy('valor', 'desc')->take(8)->get();  // Obtener los 8 activos con mayor valor
        $activosPorPrecio = $activos->map(function ($activo) {
            return [
                'nombre' => $activo->fabricante,
                'valor' => $activo->valor,
                'modelo' => $activo->modelo,
            ];
        });

        $activosPorPrecio  = collect($activosPorPrecio );


        // Pasar los datos a la vista
        return view('MenuPrincipal.VenPrincipal', compact(
            'fichasAsignadas', 
            'fichasDevueltas', 
            'fichasPrestadas', 
            'informesTecnicos',
            'incidenciasPorArea','activosPorEstado','activosPorPrecio'
        ));
    }

}