@extends('Layout.app')
@extends('Componentes.silderbar')

@section('titulo', 'PRINCIPAL')

@section('contenido')

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <div class="header">
        <h1>LISTA USUARIO</h1>
        <div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registerModal">
                Registro Usuario
            </button>
        </div>
    </div>
    <div class="search-bar">
        <form action="{{ route('buscar.personal') }}" method="POST">
            @csrf
            <div class="search-container">
                <input type="text" name="dni" id="dni-busqueda" placeholder="DNI">
                <button type="submit"> <i class="bi bi-search"></i></button>
                <a href="{{ route('personal') }}" class="search-icon">Todos</a>
            </div>
        </form>
    </div>

    <!-- Modal para Registro de Usuario -->
    <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registerModalLabel">Registro de Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('reg.perso') }}" method="POST" id="registerForm">
                        @csrf
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control" id="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="apellido">Apellido</label>
                            <input type="text" name="apellido" class="form-control" id="apellido" required>
                        </div>
                        <div class="form-group">
                            <label for="dni">DNI</label>
                            <input type="text" class="form-control" name="dni" id="dni" required>
                        </div>
                        <div class="form-group">
                            <label for="contraseña">Contraseña</label>
                            <input type="password" class="form-control" name="contraseña" id="contraseña" required>
                        </div>
                        <div class="form-group">
                            <label for="sede">Sede</label>
                            <select class="form-control" name="id_sede" id="id_sede" required>
                                @foreach ($sedes as $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="area">Area</label>
                            <select class="form-control" name="id_area" id="id_area" required>
                                @foreach ($areas as $area)
                                    <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rol">Rol Usuario</label>
                            <select class="form-control" name="idTipoPersona" id="idTipoPersona" required>
                                @foreach ($tipoPersonas as $tipoPersona)
                                    <option value="{{ $tipoPersona->id }}">{{ $tipoPersona->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th>APELLIDO</th>
                    <th>DNI</th>
                    <th>AREA</th>
                    <th>CONTRASEÑA</th>
                    <th>FECHA INGRESO</th>
                    <th>ESTADO</th>
                    <th>ROL</th>
                    <th>OPCIONES</th>
                </tr>
            </thead>
            <tbody id="userTableBody">
                @foreach ($personas as $item)
                    <tr id="persona-{{ $item->id }}">
                        <td>{{ $item->id }}</td>
                        <td>
                            <input type="text" name="nombre" id="nombre-{{ $item->id }}"
                                value="{{ $item->nombre }}" disabled>
                        </td>
                        <td>
                            <input type="text" name="apellido" id="apellido-{{ $item->id }}"
                                value="{{ $item->apellido }}" disabled>
                        </td>
                        <td>{{ $item->dni }}</td>
                        <td>{{ $item->area->nombre }}</td>
                        <td>
                            <input type="password" name="contraseña" id="contraseña-{{ $item->id }}" placeholder="---"
                                disabled>
                        </td>
                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                        <td>
                            <select class="form-control estado-select" id="estado-{{ $item->id }}" disabled>
                                <option @if ($item->estado == 0) selected @endif value="0">Activo</option>
                                <option @if ($item->estado == 1) selected @endif value="1">No activo</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control rol-select" id="rol-{{ $item->id }}" disabled>
                                @foreach ($tipoPersonas as $tipoPersona)
                                    <option value="{{ $tipoPersona->id }}"
                                        @if ($item->idTipoPersona == $tipoPersona->id) selected @endif>
                                        {{ $tipoPersona->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <button class="btn btn-warning"
                                onclick="habilitarEdicion(this, {{ $item->id }})">Editar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <div class="pagination">
        <!-- Código para la paginación -->
    </div>
    <div class="row-count">
        <!-- Código para contar filas -->
    </div>
@endsection

<script>
function habilitarEdicion(btn, id) {
    let row = btn.closest('tr');

    // Seleccionar los campos que se van a habilitar/deshabilitar
    let nombreInput = row.querySelector(`#nombre-${id}`);
    let apellidoInput = row.querySelector(`#apellido-${id}`);
    let estadoSelect = row.querySelector(`#estado-${id}`);
    let rolSelect = row.querySelector(`#rol-${id}`);
    let contraseñaInput = row.querySelector(`#contraseña-${id}`);

    // Verificar si los campos están deshabilitados (estado inicial)
    if (nombreInput && apellidoInput && estadoSelect && rolSelect && contraseñaInput) {
        if (nombreInput.disabled) {
            // Habilitar los campos para edición
            nombreInput.disabled = false;
            apellidoInput.disabled = false;
            estadoSelect.disabled = false;
            rolSelect.disabled = false;
            contraseñaInput.disabled = false;

            // Cambiar el texto del botón a "Guardar"
            btn.textContent = 'Guardar';
        } else {
            // Recoger los valores actuales de los campos
            let nombre = nombreInput.value;
            let apellido = apellidoInput.value;
            let estado = estadoSelect.value;
            let rol = rolSelect.value;
            let contraseña = contraseñaInput.value;

            // Verificar si la contraseña ha sido modificada
            // Si la contraseña sigue siendo "****", no la enviamos
            let passwordToUpdate = contraseña === "---" ? null : contraseña;

            // Hacer la solicitud AJAX para guardar los cambios
            fetch(`/personal/actualizar/${id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        nombre: nombre,
                        apellido: apellido,
                        estado: estado,
                        rol: rol,
                        contraseña: passwordToUpdate, // Solo se envía si se ha cambiado
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Error al guardar los cambios.');
                    }
                })
                .catch(error => {
                    console.error('Error en fetch:', error);
                    alert('Hubo un problema al guardar los cambios: ' + error.message);
                });
        }
    }
}
</script>
