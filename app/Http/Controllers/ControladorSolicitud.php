<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\ficha;
use App\Models\Persona;
use App\Models\sede;
use App\Models\TipoFicha;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Converter;


class ControladorSolicitud extends Controller
{
    public function FichaSolicitud()
    {
        $fichas = ficha::all();

        $queryFichas = ficha::query();

        return view('ControlActivo/Fichas/FichaSolicitud', compact('fichas'));
    }
    public function buscar(Request $request){
        $fichas = ficha::where('id', $request->id_fichab)->get();
        return view('ControlActivo/Fichas/FichaSolicitud', compact('fichas'));
    }
    public function VenAsignacion()
    {
        $tipos=TipoFicha::all();
        $activos=activo::all();
        $personas = Persona::with(['sede', 'area'])->get(); // Cargar relaciones
        $sedes=sede::all();

        return view('ControlActivo/Fichas/FichaAsignacion', compact('activos','personas','tipos', 'sedes'));
    }

    public function descargarFicha($fichaId)
{
    // Buscar la ficha por ID
    $ficha = ficha::findOrFail($fichaId);

    $phpWord = new PhpWord();
    $section = $phpWord->addSection();

    // Añadir el contenido de la ficha al documento Word
    $section->addText('Tipo de Ficha: ' . $ficha->tipo->nombre);
    $section->addText('Nombre del Usuario: ' . $ficha->persona->nombre);
    $section->addText('Detalle: ' . $ficha->detalle);
    // Añadir los activos relacionados
    $section->addText('Activos Asociados:');
    foreach ($ficha->activos as $activo) {
        $section->addText(
            $activo->id . ' - ' .$activo->categoria->nombre . ' - ' . $activo->fabricante . ' - ' . 
            $activo->modelo . ' - ' . $activo->serie . ' - ' . $activo->color
        );
    }
        
    // Guardar el documento en un archivo temporal
    $filename = 'ficha_solicitud_' . $ficha->id . '.docx';
    $filePath = storage_path('app/public/' . $filename);
    $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save($filePath);

    // Devolver el archivo como respuesta para descargarlo
    return response()->download($filePath);
}

    public function buscarPersona($dni)
    {
        $persona = Persona::where('dni', $dni)->with('sede','area')->first();  // Cargar persona con la sede

        if ($persona) {
            return response()->json([
                'persona' => $persona,
                'sede_nombre' => $persona->sede ? $persona->sede->nombre : 'Sede no asignada',
                'area_nombre' => $persona->area ? $persona->area->nombre : 'Area no asignada'
            ]);
        }

        return response()->json(['message' => 'Usuario no encontrado'], 404);
    }

    // ControladorActivo.php
    public function buscarActivo($codigo)
    {
        $activo = Activo::where('id', $codigo)->with('categoria')->first();
        return response()->json(['activo' => $activo]);
    }
    public function registrarFicha(Request $request)
{
    try {
    // Validación de los datos enviados
    $request->validate([
       'id_persona' => 'required|exists:personas,id',
        'id_tipo' => 'required|exists:tipo_fichas,id',
        'detalle' => 'required|string',
        'activos' => 'required|array|min:1',
    ]);

    $ficha = ficha::create([
        'id_persona' => $request->id_persona,
        'id_tipo' => $request->id_tipo,
        'detalle' => $request->detalle,
    ]);

    // Asegúrate de que 'activos' sea un arreglo de ids
    if ($request->has('activos') && is_array($request->activos)) {
        $activosIds = array_column($request->activos, 'id');  // Extrae solo los ids de los activos

        // Asociar los activos a la ficha (utilizando la relación muchos a muchos)
        $ficha->activos()->attach($activosIds);  // Usamos attach para asociar los activos
    }
    return response()->json(['message' => 'Ficha registrada con éxito']);
} catch (\Exception $e) {
    // Captura el error y muestra un mensaje claro
    return response()->json(['error' => 'Error al registrar la ficha.'], 500);
}
}

}
