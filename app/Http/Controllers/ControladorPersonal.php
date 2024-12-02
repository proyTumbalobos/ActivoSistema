<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Persona;
use App\Models\sede;
use App\Models\Tipo_persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ControladorPersonal extends Controller
{
    public function VenPersonal()
    {
        $sedes= sede::all();
        $areas = Area::all();
        $personas=Persona::all();
        $tipoPersonas = Tipo_persona::all();
        return view('Personal/Personal', compact('sedes','personas','areas','tipoPersonas'));
    }

    public function buscar(Request $request){
        $sedes= sede::all();
        $areas = Area::all();
        $tipoPersonas = Tipo_persona::all();

        $personas=Persona::where('dni',$request->dni)->get();
        return view('Personal/Personal', compact('sedes','personas','areas','tipoPersonas'));
    }

    public function regPersonal(Request $request)
    {
        $request->validate([]);

        Persona::create([
            'nombre'=>$request->nombre,
            'apellido'=>$request->apellido,
            'id_area'=>$request->id_area,
            'idTipoPersona'=>$request->idTipoPersona,
            'id_sede'=>$request->id_sede,
            'dni'=>$request->dni,
            'contraseña'=> Hash::make($request->contraseña),
            'estado'=>0
        ]);

        return redirect()->route('personal');

    }
    public function actualizarPersonal(Request $request, $id)
    {
        $persona = Persona::find($id);
        
        if (!$persona) {
            return response()->json(['success' => false, 'message' => 'Persona no encontrada'], 404);
        }
        
        // Validación
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'estado' => 'required|in:0,1',
            'rol' => 'required|exists:tipo_personas,id',
            'contraseña' => 'nullable|string', 
        ]);
        
        // Actualizar los datos
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->estado = $request->estado;
        $persona->idTipoPersona = $request->rol;
        if ($request->has('contraseña') && $request->contraseña) {
            $persona->contraseña = Hash::make($request->contraseña);
        }        
        $persona->updated_at = now();  // Actualizar la fecha de modificación 
        
        try {
            $persona->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al guardar los cambios: ' . $e->getMessage()], 500);
        }
    }
}