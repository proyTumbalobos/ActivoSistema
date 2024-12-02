@extends('Layout.app')
@extends('Componentes.silderbar')

@section('titulo', 'PRINCIPAL')

@section('contenido')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="header">
        <h1>Incidencias Registradas</h1>
    </div>

    <a href="{{ route('Incidencia') }}">
        <button type="button" class="btn btn-success"> Registrar incidencia</button>
    </a>

    <!-- Formulario para filtrar incidencias por estado -->
    <form action="{{ route('ListaIncidencia') }}" method="GET" style="display: inline-block; margin-left: 20px;">
        <select name="estado" onchange="this.form.submit()" class="form-control" style="width: 200px;">
            <option value="">Filtrar por Estado</option>
            <option value="abierto" {{ request('estado') == 'abierto' ? 'selected' : '' }}>Abierto</option>
            <option value="en proceso" {{ request('estado') == 'en proceso' ? 'selected' : '' }}>En Proceso</option>
            <option value="cerrado" {{ request('estado') == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
        </select>
    </form>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>FECHA</th>
                    <th>SOLICITANTE</th>
                    <th>ÁREA</th>
                    <th>DESCRIPCIÓN</th>
                    <th>ESTADO</th>
                    <th>PROCEDIMIENTO</th>
                    <th>PERSONAL ASIGNADO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody id="incidenciasTableBody">
                @foreach ($incidencias as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->fecha_ingreso }}</td>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->area->nombre }}</td>
                        <td>{{ $item->detalle }}</td>
                        <td>
                            <!-- Mostramos el estado de la incidencia sin opción de editar -->
                            <span>{{ ucfirst($item->estado) }}</span>
                        </td>
                        <td>{{ $item->procedimiento }}</td>
                        <td>{{ $item->personalEncargado->nombre ?? 'No asignado' }} {{ $item->personalEncargado->apellido ?? '' }}</td>
                        <!-- Mostramos el nombre del personal asignado -->
                        <td>
                            <button class="btn btn-editar" onclick="verDetalles({{ $item->id }})">Resolver</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal" id="resolverModal" tabindex="-1" aria-labelledby="resolverModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resolverModalLabel">Resolver Incidencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="resolverForm">
                        <input type="hidden" id="incidenciaId">
                        <div class="mb-3">
                            <label for="procedimiento" class="form-label">Procedimiento</label>
                            <textarea class="form-control" id="procedimiento" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="personal_encargado" class="form-label">Personal Encargado</label>
                            <input type="text" class="form-control" id="personal_encargado" readonly>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="finalizarIncidencia()">Finalizar Incidencia</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Función para cambiar el estado de la incidencia
        function cambiarEstado(select, idIncidencia) {
            const estado = select.value;

            fetch(`/incidencias/${idIncidencia}/estado`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    estado: estado
                })
            }).then(response => response.json())
            .then(data => {
                console.log('Estado actualizado');
            }).catch(error => {
                console.error('Error:', error);
            });
        }

        // Función para abrir el modal y cargar los detalles de la incidencia
        function verDetalles(idIncidencia) {
            $('#resolverModal').modal('show');
            document.getElementById('incidenciaId').value = idIncidencia; // Guardar el ID de la incidencia en el formulario

            // Limpiar el campo "procedimiento"
            document.getElementById('procedimiento').value = '';

            // Asignar el personal encargado en el modal
            fetch(`/incidencias/${idIncidencia}`)
                .then(response => response.json())
                .then(data => {
                    // Mostramos el nombre completo del personal
                    document.getElementById('personal_encargado').value = data.personal_encargado || 'No asignado';
                })
                .catch(error => console.error('Error al cargar los detalles:', error));

            // Cambiar el estado de la incidencia a "en proceso"
            fetch(`/incidencias/${idIncidencia}/estado`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    estado: 'en proceso'
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Estado cambiado a en proceso');
                // Recargar la página cuando se cierra el modal
                $('#resolverModal').on('hidden.bs.modal', function() {
                    location.reload(); // Recarga la página
                });
            })
            .catch(error => console.error('Error:', error));
        }

        // Función para finalizar la incidencia
        function finalizarIncidencia() {
            const procedimiento = document.getElementById('procedimiento').value;
            const idIncidencia = document.getElementById('incidenciaId').value;

            fetch(`/incidencias/${idIncidencia}/resolver`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    procedimiento: procedimiento,
                    personal_encargado: '{{ auth()->user()->id }}' // Enviar el ID del usuario actual
                })
            }).then(response => response.json())
            .then(data => {
                $('#resolverModal').modal('hide');
                location.reload(); // Recargar la página para reflejar el cambio
            }).catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
@endsection
