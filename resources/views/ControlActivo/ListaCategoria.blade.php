@extends('Layout.app')
@extends('Componentes.silderbar')

@section('titulo', 'ACTIVOS')

@section('contenido')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="header">
        <h1>LISTA DE CATEGORÍA</h1>
    </div>

    <div class="search-bar">
        <!-- Formulario para búsqueda de categorías -->
        <form action="{{ route('buscar.categoria') }}" method="POST">
            @csrf
            <div class="search-container">
                <input type="text" name="name" id="name" placeholder="Busca nombre categoría">
                <button type="submit"> <i class="bi bi-search"></i></button>
                <a href="{{ route('lista.categoria') }}" class="search-icon">Todos</a>
            </div>
        </form>

        <!-- Formulario para agregar nuevas categorías -->
        <form action="{{ route('categoria.guardar') }}" method="POST">
            @csrf
            <div class="search-container">
                <input type="text" name="name" id="name" placeholder="Ingresar nueva categoría" required>
                <button type="submit">Guardar</button>
            </div>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOMBRE CATEGORÍA</th>
                    <th>CANTIDAD</th>
                    <th>FECHA INGRESO</th>
                    <th>FECHA ACTUALIZACIÓN</th>
                    <th>OPCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categorias as $item)
                    <tr id="row_{{ $item->id }}">
                        <td>{{ $item->id }}</td>
                        <td>
                            <input type="text" style="border: none; color:brown;" id="name_{{ $item->id }}" value="{{ $item->name }}" disabled>
                        </td>
                        <td>{{ $item->productos_count }}</td>
                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                        <td id="updated_at_{{ $item->id }}">{{ $item->updated_at->format('Y-m-d') }}</td>
                        <td>
                            <button class="btnRegistro" style="background-color: blueviolet"
                                id="edit_{{ $item->id }}">Editar</button>
                            <button class="btnGuardar" style="background-color: green; display: none;"
                                id="save_{{ $item->id }}">Guardar</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Asignar eventos a los botones de "Editar"
        document.querySelectorAll('.btnRegistro').forEach((button) => {
            button.addEventListener('click', function() {
                let row = button.closest('tr');
                let id = row.id.split('_')[1]; // Obtener ID de la categoría
                toggleEdit(id); // Habilitar edición
            });
        });

        // Asignar eventos a los botones de "Guardar"
        document.querySelectorAll('.btnGuardar').forEach((button) => {
            button.addEventListener('click', function() {
                let row = button.closest('tr');
                let id = row.id.split('_')[1]; // Obtener ID de la categoría
                guardarCategoria(id); // Enviar la actualización al servidor
            });
        });
    });

    function toggleEdit(id) {
        var nameInput = document.getElementById("name_" + id);
        var editButton = document.getElementById("edit_" + id);
        var saveButton = document.getElementById("save_" + id);

        // Cambiar estado de los botones y habilitar el input
        if (nameInput.disabled) {
            nameInput.disabled = false;
            editButton.style.display = 'none';
            saveButton.style.display = 'inline-block';
        }
    }

    function guardarCategoria(id) {
        var nameInput = document.getElementById("name_" + id);
        var name = nameInput.value;

        // Obtener el CSRF token para seguridad
        var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Realizar la solicitud AJAX
        fetch('{{ route('categoria.actualizar') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    id: id,
                    name: name
                })
            })
            .then(response => response.json())
            .then(data => {
                // Deshabilitar el campo y ocultar el botón de guardar
                nameInput.disabled = true;
                document.getElementById("edit_" + id).style.display = 'inline-block';
                document.getElementById("save_" + id).style.display = 'none';

                // Actualizar la fecha de actualización en la tabla
                document.getElementById('updated_at_' + id).innerText = data.updated_at;

                // Mensaje de éxito
                alert('Categoría actualizada con éxito');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Hubo un error al actualizar la categoría.');
            });
    }
</script>
