@extends('Layout.app')
@extends('Componentes.silderbar')

@section('titulo', 'FICHA SOLICIUD')

@section('contenido')
    <div class="header">
        <h1>LISTADO DE FICHA SOLICIUD</h1>
        <div>
            <a href="{{ route('asignacion') }}" class="btnRegistro">REGISTRAR</a>
        </div>
    </div>
    <div class="search-bar">
        <form method="POST" action="{{ route('ficha.buscar') }}">
            @csrf
            <div class="search-container">
                <input type="text" name="id_fichab" id="id_fichab" placeholder="CÓDIGO FICHA">
                <button type="submit"> <i class="bi bi-search"></i> <!-- Icono de lupa -->
                </button>
            </div>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>CÓDIGO FICHA</th>
                    <th>TIPO FICHA</th>
                    <th>FECHA INGRESO</th>
                    <th>PERSONAL</th>
                    <th>ÁREA</th>
                    <th>SEDE</th>
                    <th>DETALLE</th>
                    <th>OPCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fichas as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->tipo->nombre }}</td>
                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                        <td>{{ $item->persona->nombre }}</td>
                        <td>{{ $item->persona->area->nombre }}</td>
                        <td>{{ $item->persona->sede->nombre }}</td>
                        <td>{{ $item->detalle }}</td>
                        <td>
                            <a href="{{ route('ficha.descargar', ['ficha' => $item->id]) }}"><i class="bi bi-filetype-docx"></i></a>
                            <button class="btn-ver-activos" data-ficha-id="{{ $item->id }}"><i class="bi bi-eye"></i></button>
                        </td>
                    </tr>
                    <!-- Fila para los Activos, que estará oculta inicialmente -->
                    <tr class="activos-row" id="activos-{{ $item->id }}" style="display: none;">
                        <td colspan="8">
                            <table style="width: 70%; margin: 0 auto;">
                                <thead>
                                    <tr>
                                        <th>Codigo Inventario</th>
                                        <th>Categoría</th>
                                        <th>Fabricante</th>
                                        <th>Modelo</th>
                                        <th>Serie</th>
                                        <th>Color</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($item->activos as $activo)
                                        <tr>
                                            <td>{{ $activo->id }}</td>
                                            <td>{{ $activo->categoria->name }}</td>
                                            <td>{{ $activo->fabricante }}</td>
                                            <td>{{ $activo->modelo }}</td>
                                            <td>{{ $activo->serie }}</td>
                                            <td>{{ $activo->color }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtenemos todos los botones "Ver Activos"
        const buttons = document.querySelectorAll('.btn-ver-activos');

        // Añadimos evento de clic a cada uno de los botones
        buttons.forEach(button => {
            button.addEventListener('click', function() {
                // Obtener el ID de la ficha asociada al botón
                const fichaId = this.dataset.fichaId;
                const activosRow = document.getElementById('activos-' + fichaId);

                // Primero, verificamos si la fila ya está abierta
                if (activosRow.style.display === 'table-row') {
                    // Si está abierta, la cerramos
                    activosRow.style.display = 'none';
                } else {
                    // Si está cerrada, la mostramos
                    // Primero, ocultamos todas las filas de activos
                    const allActivosRows = document.querySelectorAll('.activos-row');
                    allActivosRows.forEach(row => row.style.display = 'none');

                    // Ahora mostramos la fila seleccionada
                    activosRow.style.display = 'table-row';
                }
            });
        });
    });
</script>
