<?php
namespace App\Http\Controllers;

use App\Models\activo;
use App\Models\CategoriaActivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ControladorActivo extends Controller
{
    public function listaActivo()
    {
        $activos = activo::all();
        return view('ControlActivo/ListaActivo', compact('activos'));
    }

    public function buscar(Request $request)
    {
        $activos = activo::where('id', $request->id)->get();
        return view('ControlActivo/ListaActivo', compact('activos'));
    }

    public function VenActivo()
    {
        // Vista para registrar activos
        $categorias = CategoriaActivo::all();
        return view('ControlActivo/RegistroActivo', compact('categorias'));
    }

    public function guardarActivos(Request $request)
    {
        try {
            $activos = $request->input('activos'); // Obtener el array de activos
    
            foreach ($activos as $activo) {
                // Guardar cada activo en la base de datos
                Activo::create([
                    'fechacompra' => $activo['fecha'],
                    'estado' => 'Activo',
                    'id_categoria' => $activo['tipoEquipo'],
                    'fabricante' => $activo['fabricante'],
                    'modelo' => $activo['modelo'],
                    'serie' => $activo['serie'],
                    'ip' => $activo['ip'],
                    'color' => $activo['color'],
                    'valor' => $activo['valor'],
                    'n_orden' => $activo['n_orden'],
                ]);
            }
    
            // Redirigir al frontend con un JSON que incluye la URL para redirigir
            return response()->json([
                'success' => true,
                'redirect_url' => route('lista.activos') // Esto es lo que redirige en el frontend
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage()); // Registrar el error en el log
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al guardar los activos.'
            ]);
        }
    }    
}
