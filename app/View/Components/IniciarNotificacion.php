<?php
namespace App\View\Components;

use App\Models\Incidencia;
use Illuminate\View\Component;

class IniciarNotificacion extends Component
{
    public $incidenciasNoVistas;

    public function __construct()
    {
        // Obtener las incidencias no vistas
        $this->incidenciasNoVistas = Incidencia::where('visto', false)->get();
    }

    public function render()
    {
        return view('Componentes.VerNotificacion'); // Corregido aquí
    }
}