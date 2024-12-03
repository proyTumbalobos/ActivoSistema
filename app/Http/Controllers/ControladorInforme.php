<?php

namespace App\Http\Controllers;

use App\Models\activo;
use App\Models\Informe;
use App\Models\Persona;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class ControladorInforme extends Controller
{
    public function Informe()
    {
        $informes = Informe::all();
        return view('ControlActivo/InformeTecnico/InformeTenico', compact('informes'));
    }

    public function Busqueda(Request $request){
        
        $informes= Informe::where('id_activo',$request->id_activo)->get();

        return view('ControlActivo/InformeTecnico/InformeTenico', compact('informes'));
    }

    
    public function InformeBusqueda()
    {
        return view('ControlActivo/InformeTecnico/Historial');
    }

    public function VenCrearFicha()
    {   
        $persona = null;
        $activo = null;
        $sede = null;
        $area = null;
        return view('ControlActivo/InformeTecnico/crearFicha', compact('persona','activo','sede','area'));
    }

    public function buscarFicha(Request $request){
        $persona = Persona::where('dni', $request->dni)->with('sede','area')->first();
        
        $activo = activo::where('id', $request->id_activo)->first();
        return view('ControlActivo/InformeTecnico/crearFicha', compact('persona','activo'));
    }

    public function descargarInforme($fichaId){
    // Buscar la ficha por ID
    $ficha = Informe::findOrFail($fichaId);

    // Crear un objeto PhpWord para generar el archivo Word
    $phpWord = new PhpWord();
    $section = $phpWord->addSection();

    // Agregar datos al archivo word
    $section->addText('Fecha: ' . Carbon::now()->format('d/m/Y'));
    $section->addText('Estado: ' . $ficha->activo->estado);
    $section->addText('Activo Asignado: ' . $ficha->activo->id . ' - ' . $ficha->activo->modelo . ' - ' . $ficha->activo->serie); // Agregar modelo y serie del activo
    $section->addText('Nombre del Personal: ' . $ficha->persona->nombre . '  ' . $ficha->persona->apellido); // Apellido del usuario
    $section->addText('Sede: ' . $ficha->persona->sede->nombre);  // Sede del usuario
    $section->addText('Problema: ' . $ficha->problema);
    $section->addText('Procedimiento: ' . $ficha->prueba);
    $section->addText('Conclusión: ' . $ficha->conclusion);
    $section->addText('Personal Encargado del Mantenimiento: ' . Auth::user()->nombre . ' ' . Auth::user()->apellido);


    // Guardar el archivo generado en una ubicación
    $filename = 'informe_' . $ficha->id . '.docx';
    $filePath = storage_path('app/public/' . $filename);
    $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save($filePath);

    // Devolver el archivo como respuesta para la descarga
    return response()->download($filePath);
}

    // Método para generar el documento Word
    public function generarInforme(Request $request)
    {
        // Registrar datos en la base de datos
        $activo = activo::find($request->id_activo);
        $activo->estado = 'Mantenimiento';  // Actualizar el estado del activo
        $activo->save();

        Informe::create([
            'fecha' => Carbon::now(),
            'id_activo' => $request->id_activo,
            'id_persona' => $request->id_persona,
            'problema' => $request->problema,
            'prueba' => $request->prueba, 
            'conclusion' => $request->conclusion,
        ]);

        // Generar el informe en formato Word
        $activo = activo::find($request->id_activo);
        $persona = Persona::find($request->id_persona);

        // Verificar si el activo existe
        if (!$activo) {
            return redirect()->back()->with('error', 'Activo no encontrado');
        }

        // Crear un nuevo documento Word
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Agregar los datos al documento
        $section->addText('Fecha: ' . Carbon::now()->format('d/m/Y'));
        $section->addText('Estado: ' . $activo->estado);
        $section->addText('Usuario: '  . $persona->nombre . '  ' . $persona->apellido);
        $section->addText('DNI: ' . ($persona ? $persona->dni : 'No disponible'));
        $section->addText('Sede: ' . $persona->sede->nombre);  // Sede del usuario
        $section->addText('Código Inventario: ' . $activo->id);
        $section->addText('Categoría: ' . ($activo->categoria ? $activo->categoria->name : 'No disponible'));
        $section->addText('Modelo: ' . $activo->modelo);
        $section->addText('Serie: ' . $activo->serie);
        $section->addText('Fabricante: ' . $activo->fabricante);
        $section->addText('Problema: ' . $request->problema);
        $section->addText('Procedimiento: ' . $request->prueba);
        $section->addText('Conclusión: ' . $request->conclusion); 
        $section->addText('Personal Encargado del Mantenimiento: ' . Auth::user()->nombre . ' ' . Auth::user()->apellido);

        // Guardar el documento como archivo .docx
        $filename = 'ficha_informe_' . Carbon::now()->format('YmdHis') . '.docx';
        $filePath = storage_path('app/public/' . $filename);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filePath);

        // Devolver el archivo como respuesta para la descarga
        return response()->download($filePath);
    }
    

    public function cambiarEstado(Request $request){
        $activo = activo::find($request->id_activo);

        $activo->estado = $request->estado;
        $activo->save();

        return redirect()->route('informe');
    }
}