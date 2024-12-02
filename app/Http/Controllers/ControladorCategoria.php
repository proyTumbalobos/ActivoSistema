<?php

namespace App\Http\Controllers;

use App\Models\CategoriaActivo;
use Illuminate\Http\Request;

class ControladorCategoria extends Controller
{
    public function listaCategoria(){
        // Obtener todas las categorías y contar los productos asociados a cada una
        $categorias = CategoriaActivo::withCount('productos')->get();
        return view('ControlActivo.ListaCategoria', compact('categorias'));
    }

    public function buscar(Request $request){
        // Buscar categorías por nombre
        $categorias = CategoriaActivo::where('name', 'like', '%' . $request->name . '%')->get();
        return view('ControlActivo.ListaCategoria', compact('categorias'));
    }

    public function guardarCategoria(Request $request)
    {
        // Validar los datos
        $request->validate([
            'name' => 'required|string|max:30',
        ]);

        // Crear una nueva categoría
        $categoria = new CategoriaActivo();
        $categoria->name = $request->name;
        $categoria->save();

        // Redirigir a la lista de categorías
        return redirect()->route('lista.categoria');
    }

    public function actualizarCategoria(Request $request)
    {
        // Validar los datos
        $request->validate([
            'id' => 'required|exists:categoria_activos,id', // Asegúrate de que la tabla se llame correctamente
            'name' => 'required|string|max:30',
        ]);

        // Buscar la categoría y actualizar su nombre
        $categoria = CategoriaActivo::find($request->id);
        $categoria->name = $request->name;
        $categoria->save();

        // Retornar la fecha de actualización en formato JSON
        return response()->json([
            'updated_at' => $categoria->updated_at->format('Y-m-d')
        ]);
    }
}
