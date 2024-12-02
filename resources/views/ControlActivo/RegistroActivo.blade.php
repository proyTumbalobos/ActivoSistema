@extends('Layout.app')
@extends('Componentes.silderbar')

@section('titulo', 'PRINCIPAL')

@section('contenido')
    <link rel="stylesheet" href="css/registro.css">

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body>
        <div>
            <!-- Formulario en la parte superior -->
            <div class="form-container">
                <!-- Fila 1: Fecha de Compra, Tipo de Equipo, Fabricante -->
                <div class="row">
                    <div class="col">
                        <label for="fecha">Fecha de Compra:</label>
                        <input type="date" id="fecha" name="fecha" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="col">
                        <label for="tipo-equipo">Tipo de Equipo:</label>
                        <select id="tipo-equipo">
                            @foreach ($categorias as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <label for="fabricante">Fabricante:</label>
                        <input type="text" id="fabricante" placeholder="Fabricante">
                    </div>

                    <div class="col">
                        <label for="modelo">Modelo:</label>
                        <input type="text" id="modelo" placeholder="Modelo">
                    </div>
                </div>

                <!-- Fila 2: Modelo, Serie, IP -->
                <div class="row">
                    <div class="col">
                        <label for="serie">Serie:</label>
                        <input type="text" id="serie" placeholder="Serie">
                    </div>

                    <div class="col">
                        <label for="valor">Valor de compra:</label>
                        <input step="0.01" min="0" type="number" id="valor" placeholder="0.00">
                    </div>
                    <div class="col">
                        <label for="n_orden">Número de orden:</label>
                        <input type="text" id="n_orden" placeholder="n°">
                    </div>
                    <div class="col">
                        <label for="color">Color:</label>
                        <input type="text" id="color" placeholder="Color">
                    </div>

                </div>

                <!-- Fila 3: Valor de compra, Número de orden, Color -->
                <div class="row">

                    <div class="col">
                        <label for="ip">IP:</label>
                        <input type="text" id="ip" placeholder="IP">
                    </div>

                    <div class="col">
                        <button class="form-btn" onclick="addActivo()">AGREGAR ACTIVO</button>
                        <button class="form-btn" onclick="enviarActivos()">GUARDAR LISTA DE ACTIVOS</button>
                    </div>
                </div>
            </div>

            <!-- Tabla en la parte inferior -->
            <div class="table-container">
                <table id="tabla-activos">
                    <thead>
                        <tr>
                            <th>FECHA COMPRA</th>
                            <th>ESTADO</th>
                            <th>TIPO EQUIPO</th>
                            <th>FABRICANTE</th>
                            <th>MODELO</th>
                            <th>SERIE</th>
                            <th>IP</th>
                            <th>COLOR</th>
                            <th>COSTO</th>
                            <th>ORDEN COMPRA</th>
                            <th>OPCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Las filas se agregarán aquí dinámicamente -->
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            // Array para almacenar los activos antes de enviarlos al backend
            let activos = [];

            // Función para agregar un activo a la tabla y al array de activos
            function addActivo() {
                const fecha = document.getElementById('fecha').value;
                const tipoEquipo = document.getElementById('tipo-equipo').value;
                const tipoEquipoTexto = document.getElementById('tipo-equipo').options[document.getElementById('tipo-equipo')
                    .selectedIndex].text;
                const fabricante = document.getElementById('fabricante').value;
                const modelo = document.getElementById('modelo').value;
                const serie = document.getElementById('serie').value;
                const ip = document.getElementById('ip').value;
                const color = document.getElementById('color').value;
                const valor = document.getElementById('valor').value;
                const n_orden = document.getElementById('n_orden').value;
                // Crear un objeto de activo y agregarlo al array
                const activo = {
                    fecha,
                    tipoEquipo,
                    fabricante,
                    modelo,
                    serie,
                    ip,
                    color,
                    valor,
                    n_orden
                };
                activos.push(activo);

                // Agregar el activo a la tabla
                const tabla = document.getElementById('tabla-activos').getElementsByTagName('tbody')[0];
                const nuevaFila = tabla.insertRow();

                nuevaFila.innerHTML = `
                    <td>${fecha}</td>
                    <td>Activo</td>
                    <td>${tipoEquipoTexto}</td>
                    <td>${fabricante}</td>
                    <td>${modelo}</td>
                    <td>${serie}</td>
                    <td>${ip}</td>
                    <td>${color}</td>
                    <td>${valor}</td>
                    <td>${n_orden}</td>
                    <td><button onclick="eliminarActivo(${activos.length - 1})">Eliminar</button></td>`;

                // Limpiar el formulario después de agregar el activo
                resetForm();
            }

            // Función para eliminar un activo de la tabla y del array
            function eliminarActivo(index) {
                activos.splice(index, 1);
                mostrarActivos();
            }

            // Función para mostrar los activos en la tabla
            function mostrarActivos() {
                const tabla = document.getElementById('tabla-activos').getElementsByTagName('tbody')[0];
                tabla.innerHTML = '';

                activos.forEach((activo, index) => {
                    const fila = tabla.insertRow();
                    fila.innerHTML = `
                        <td>${activo.fecha}</td>
                        <td>Activo</td>
                        <td>${document.getElementById('tipo-equipo').options[activo.tipoEquipo - 1].text}</td>
                        <td>${activo.fabricante}</td>
                        <td>${activo.modelo}</td>
                        <td>${activo.serie}</td>
                        <td>${activo.ip}</td>
                        <td>${activo.color}</td>
                        <td>${activo.valor}</td>
                        <td>${activo.n_orden}</td>
                        <td><button onclick="eliminarActivo(${index})">Eliminar</button></td>
                    `;
                });
            }

            // Función para resetear el formulario
            function resetForm() {
                document.getElementById('fabricante').value = '';
                document.getElementById('modelo').value = '';
                document.getElementById('serie').value = '';
                document.getElementById('ip').value = '';
                document.getElementById('color').value = '';
                document.getElementById('valor').value = '';
                document.getElementById('n_orden').value = '';
            }

            function enviarActivos() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch('/guardar-activos', { // URL correcta
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            activos
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Si la respuesta contiene un mensaje de éxito
                        if (data.success) {
                            window.location.href = data.redirect_url; // Redirige al URL proporcionado por el servidor
                        } else {
                            alert('Ocurrió un error, por favor intenta nuevamente.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ocurrió un error, por favor intenta nuevamente.');
                    });
            }
        </script>
    </body>
@endsection
