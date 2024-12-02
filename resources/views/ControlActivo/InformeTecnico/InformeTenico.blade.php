@extends('Layout.app')
@extends('Componentes.silderbar')

@section('titulo', 'TECNICO')

@section('contenido')
    <div class="header">
        <h1>INFORME TECNICO</h1>
        <div>
            <a href="{{ route('crearFicha') }}" class="btnRegistro">REGISTRAR</a>
        </div>
    </div>
    <div class="search-bar">
        <form action="{{ route('busqueda.informe') }}" method="POST">
            @csrf
            <div class="search-container">
                <input type="text" name="id_activo" id="id_activo" placeholder="CÓDIGO INVENTARIO">
                <button type="submit"> <i class="bi bi-search"></i></button>
                <a href="{{ route('informe') }}" class="search-icon">Todos</a>
                <i class="fas fa-circle" style="color: green;"></i> Activo operativo
                <i class="fas fa-circle" style="color: red;"></i> Activo no operativo
            </div>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>CÓDIGO INFORME</th>
                    <th>CÓDIGO INVENTARIO</th>
                    <th>FECHA INGRESO</th>
                    <th>CATEGORIA</th>
                    <th>MODELO</th>
                    <th>SERIE</th>
                    <th>PERSONAL</th>
                    <th>PROBLEMA</th>
                    <th>ESTADO</th>
                    <th>OPCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($informes as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->activo->id }}</td>
                        <td>{{ $item->fecha }}</td>
                        <td>{{ $item->activo->categoria->name }}</td>
                        <td>{{ $item->activo->modelo }}</td>
                        <td>{{ $item->activo->serie }}</td>
                        <td>{{ $item->persona->nombre }}</td>
                        <td>{{ $item->problema }}</td>
                        <td>{{ $item->activo->estado }}</td>
                        <td>
                            <form action="{{ route('cambiar.estado') }}" method="POST">
                                @csrf
                                <input name="id_activo" type="hidden" value="{{ $item->activo->id }}">
                                <input type="hidden" name="estado" value="Activo">
                                <button type="submit"> <i class="fas fa-circle" style="color: green;"></i></button>
                            </form>

                            <form action="{{ route('cambiar.estado') }}" method="POST">
                                @csrf
                                <input name="id_activo" type="hidden" value="{{ $item->activo->id }}">
                                <input type="hidden" name="estado" value="No operativo">
                                <button type="submit"><i class="fas fa-circle" style="color: red;"></i></button>
                            </form>
                            <button class="btn-ver-detalle" data-informe-id="{{ $item->id }}"><i class="bi bi-eye"></i></button>
                            <a href="{{ route('informe.descargar', ['fichaId' => $item->id]) }}"><i class="bi bi-filetype-docx"></i></a>
                        </td>
                    </tr>

                    <!-- Acordeón de detalles -->
                    <tr id="activos-{{ $item->id }}" class="activos-row" style="display: none;">
                        <td colspan="10">
                            <div>
                                <strong>Personal Encargado:</strong> {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}<br>
                                <strong>Procedimiento:</strong> {{ $item->prueba }}<br>
                                <strong>Conclusión:</strong> {{ $item->conclusion }}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn-ver-detalle');

        buttons.forEach(button => {
            button.addEventListener('click', function() {
                const informeId = this.dataset.informeId;
                const activosRow = document.getElementById('activos-' + informeId);

                if (activosRow.style.display === 'table-row') {
                    activosRow.style.display = 'none';
                } else {
                    // Ocultar otras filas abiertas
                    const allActivosRows = document.querySelectorAll('.activos-row');
                    allActivosRows.forEach(row => row.style.display = 'none');

                    // Mostrar la fila correspondiente
                    activosRow.style.display = 'table-row';
                }
            });
        });
    });
</script>
