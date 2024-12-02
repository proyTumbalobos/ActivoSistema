@extends('Layout.app')
@extends('Componentes.silderbar')

@section('titulo', 'Generar Ficha')

@section('contenido')
    <header>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </header>

    <div>
        <div class="form-container" style="width: 35%; float: left; padding: 80px 10px; text-align: left;">

            <div class="mb-4 d-flex align-items-center">
                <label for="tipoFicha" class="me-3" style="width: 160px;">Tipo de ficha:</label>
                <select id="tipoFicha" class="form-select" style="width: 400px;">
                    <option value="" disabled selected>Selecciona Ficha</option> <!-- Texto predeterminado -->
                    @foreach ($tipos as $item)
                        <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4 d-flex align-items-center">
                <label for="usuarioDNI" class="me-3" style="width: 160px;">Nombre Usuario:</label>
                <div class="input-group" style=" width: 400px;">
                    <input type="text" id="usuarioDNI" class="form-control" placeholder="DNI">
                    <button type="button" id="buscarUsuario" class="btn btn-success">BUSCAR</button>
                </div>
                <span id="usuarioInfo" class="ms-2"></span>
            </div>

            <div class="mb-4 d-flex align-items-center">
                <label for="codigoActivo" class="me-3" style="width: 160px;">Código Inventario:</label>
                <div class="input-group" style=" width: 400px;">
                    <input type="text" id="codigoActivo" class="form-control" placeholder="Código Inventario">
                    <button type="button" id="agregarActivo" class="btn btn-success">AGREGAR</button>
                </div>
            </div>

            <div class="mb-4">
                <label for="detalle" class="form-label">Detalle:</label>
                <textarea id="detalle" class="form-control" placeholder="Escribe los detalles aquí..." rows="4"></textarea>
            </div>

            <div style="text-align: center;">
                <button type="button" id="registrarFicha" class="btn btn-info">REGISTRAR FICHA</button>
            </div>
        </div>


        <!-- Vista previa de la ficha con los datos dinámicos -->
        <div style="width: 63%; float: right; padding: 10px 0;">
            <div id="vistaPrevia">
                <table>
                    <tr>
                        <td class="table-header" colspan="1">FICHA SOLICITUD:</td>
                        <td id="previewTipoFicha"></td>
                        <td class="table-header" colspan="1">FECHA:</td>
                        <td colspan="1">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="table-header">DATO USUARIO:</td>
                        <td colspan="3" id="previewUsuario"></td>
                    </tr>
                    <tr>
                        <td class="table-header">SEDE:</td>
                        <td id="previewSede"></td>
                        <td class="table-header">ÁREA:</td>
                        <td id="previewArea"></td>
                    </tr>
                </table>
                
                <br>
        
                <!-- Tabla para detalles del activo -->
                <table id="activoTable">
                    <tr>
                        <td colspan="5" class="table-header">DETALLE DEL ACTIVO</td>
                    </tr>
                    <tr>
                        <td>Código Inventario</td>
                        <td>Categoría</td>
                        <td>Fabricante</td>
                        <td>Modelo</td>
                        <td>Serie</td>
                    </tr>
                    <!-- Aquí se agregarán los activos dinámicamente -->
                </table>
                
                <br>
        
                <!-- Tabla para Recibe y Entrega de Activo -->
                <table>
                    <tr>
                        <td class="table-header" colspan="2">RECIBE ACTIVO</td>
                        <td class="table-header" colspan="2">ENTREGA ACTIVO</td>
                    </tr>
                    <tr>
                        <td colspan="2" id="recibeUsuario"></td>
                        <td colspan="2" id="entregaUsuario"></td>
                    </tr>
                </table>
                
                <br>
        
                <!-- Tabla para detalle adicional -->
                <table>
                    <tr>
                        <th colspan="1" class="table-header">DETALLE</th>
                        <td colspan="3" id="previewDetalle"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const activos = [];
            let usuarioAsignado = null;

            document.getElementById('tipoFicha').addEventListener('change', function() {
                const tipoFichaNombre = this.options[this.selectedIndex].text;
                document.getElementById('previewTipoFicha').textContent = tipoFichaNombre;
            });

            document.getElementById('detalle').addEventListener('input', function() {
                document.getElementById('previewDetalle').textContent = this.value;
            });

            // Buscar usuario por DNI
            document.getElementById('buscarUsuario').addEventListener('click', function() {
                const dni = document.getElementById('usuarioDNI').value;

                if (!dni) {
                    alert('Por favor, ingrese el DNI.');
                    return;
                }

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/buscar-persona/${dni}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.persona) {
                            usuarioAsignado = data.persona;

                            // Mostrar el nombre completo del usuario en la vista previa
                            const nombreUsuario = `${data.persona.nombre} ${data.persona.apellido}`;
                            document.getElementById('previewUsuario').textContent = nombreUsuario;
                            document.getElementById('usuarioDNI').value = nombreUsuario;

                            // Mostrar el nombre de la sede
                            const sedeNombre = data.sede_nombre ||
                            'Sede no asignada'; // Obtener el nombre de la sede
                            document.getElementById('previewSede').textContent = sedeNombre;

                            // Mostrar el nombre de la sede
                            const areaNombre = data.area_nombre ||
                            'Area no asignada'; // Obtener el nombre del area
                            document.getElementById('previewArea').textContent = areaNombre;

                            // Datos de "Recibe Activo" y "Entrega Activo"
                            document.getElementById('recibeUsuario').textContent = nombreUsuario;
                            document.getElementById('entregaUsuario').textContent =
                            nombreUsuario; // Esto podría cambiar según tu lógica
                            // Limpiar el campo de búsqueda (DNI)
                            document.getElementById('usuarioDNI').value = '';
                        } else {
                            alert('Usuario no encontrado');
                        }
                    })
                    .catch(error => {
                        console.error('Error al buscar el usuario:', error);
                    });
            });

            // Agregar activo a la lista de activos seleccionados
            document.getElementById('agregarActivo').addEventListener('click', function() {
                const codigo = document.getElementById('codigoActivo').value;

                if (!codigo) {
                    alert('Por favor, ingrese el código del activo.');
                    return;
                }

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/buscar-activo/${codigo}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.activo) {
                            const listItem = document.createElement('tr');
                            const categoria = data.activo.categoria ? data.activo.categoria.name :
                                'Sin categoría';
                            listItem.innerHTML = `
                        <td style="background:white">${data.activo.id}</td>
                        <td style="background:white">${categoria}</td>
                        <td style="background:white">${data.activo.fabricante}</td>
                        <td style="background:white">${data.activo.modelo}</td>
                        <td style="background:white">${data.activo.serie}</td>
                    `;
                            document.getElementById('activoTable').appendChild(listItem);

                            activos.push({
                                id: data.activo.id,
                                categoria: categoria,
                                fabricante: data.activo.fabricante,
                                modelo: data.activo.modelo,
                                serie: data.activo.serie
                            });
                            document.getElementById('codigoActivo').value = '';
                        } else {
                            alert('Activo no encontrado');
                        }
                    })
                    .catch(error => {
                        console.error('Error al buscar el activo:', error);
                    });
            });

            document.getElementById('registrarFicha').addEventListener('click', function() {
                if (!usuarioAsignado) {
                    alert('Persona no asignada');
                    return;
                }

                const tipoFicha = document.getElementById('tipoFicha').value;
                const detalle = document.getElementById('detalle').value;
                if (activos.length === 0) {
                    alert('Por favor, agregue al menos un activo.');
                    return;
                }

                fetch('registrar-ficha', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                        },
                        body: JSON.stringify({
                            id_persona: usuarioAsignado.id,
                            id_tipo: tipoFicha,
                            detalle: detalle,
                            activos: activos,
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message) {
                            alert('Ficha registrada con éxito');
                            window.history.back(); // Regresa a la página anterior
                        } else {
                            alert('Error al registrar la ficha: ' + data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>
@endsection
