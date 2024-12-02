@extends('Layout.app')
@extends('Componentes.silderbar')

@section('titulo', 'PRINCIPAL')

@section('contenido')

<body>
    <!-- Formulario del lado izquierdo -->
    <div class="form-container" style="width: 38%; float: left; padding: 20px 0; text-align: left;">
        <!-- Fila 2: Nombre de Usuario y Código Inventario -->
        <form action="{{ route('buscar.p.a.iTecnico') }}" method="post">
            @csrf
            <div class="row">
                <div class="col">
                    <label for="usuario" class="me-3">DNI Usuario:</label>
                    <input type="text" id="dni" name="dni" placeholder="Busque el DNI..." class="form-control">
                </div>

                <div class="col">
                    <label for="codigo" class="me-3">Código Inventario:</label>
                    <div class="input-group" style="width: 270px; margin-left:-20px;">
                        <input type="text" id="id_activo" name="id_activo" placeholder="Busque ..." class="form-control">
                        <button type="submit" class="btn btn-info">🔍</button>
                    </div>
                </div>
            </div>
        </form>
        <br>

        <!-- Fila 3: Detalles -->
        <form action="{{ route('generarInforme') }}" method="POST">
            @csrf
            <input
                @if ($activo) value="{{ $activo->id }}"
                @else
                    value="" @endif
                type="hidden" id="id_activo" name="id_activo">

            <input
                @if ($persona) value="{{ $persona->id }}"
                @else
                    value="" @endif
                type="hidden" id="id_persona" name="id_persona">

            <div class="mb-4">
                <label for="detalle" class="me-3">Problema:</label>
                <textarea id="problema" name="problema" class="form-control" placeholder="Escribe el problema aquí..." rows="4" oninput="updatePreview('problema')"></textarea>
            </div>

            <div class="mb-4">
                <label for="prueba">Procedimiento:</label>
                <textarea id="prueba" name="prueba" class="form-control" placeholder="Escribe el procedimiento aquí..." rows="4" oninput="updatePreview('prueba')"></textarea>
            </div>

            <div class="mb-4">
                <label for="conclusion">Conclusión:</label>
                <textarea id="conclusion" name="conclusion" class="form-control" placeholder="Escribe la conclusión aquí..." rows="4" oninput="updatePreview('conclusion')"></textarea>
            </div>

            <!-- Fila 4: Botones -->
            <div class="mb-4">
                <button @if ($activo == null || $persona == null) disabled @endif type="submit" class="btn btn-success">Registrar Ficha tecnica</button>
            </div>
        </form>
    </div>

    <!-- Documento autocompletado del lado derecho -->
    <div style="width: 60%; float: right; padding: 10px 0;">
        <div id="vistaPrevia">
            <h2>INFORME TECNICO</h2>
            <p>Datos Generales</p>
            <table>
                <tr>
                    <td class="table-header">Fecha:</td>
                    <td>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td class="table-header">Dato Usuario:</td>
                    <td id="doc-usuario">
                        @if ($persona)
                            {{ $persona->nombre }} {{ $persona->apellido }}
                        @else
                            persona no encontrada
                        @endif
                    </td>

                    <td class="table-header">Estado:</td>
                    <td id="doc-estado">
                        @if ($activo)
                            {{ $activo->estado }}
                        @else
                            activo no encontrado
                        @endif
                    </td>
                </tr>
                <tr>

                    <td class="table-header">Area:</td>
                    <td  id="doc-usuario">
                        @if ($persona)
                            {{ $persona->area->nombre }}
                        @else
                            activo no encontrado
                        @endif
                    </td>

                    <td class="table-header">Sede:</td>
                    <td id="doc-codigo">
                        @if ($persona)
                            {{ $persona->sede->nombre }}
                        @else
                            activo no encontrado
                        @endif
                    </td>

                </tr>
                <tr>
                

                    <td class="table-header">Categoria:</td>
                    <td id="doc-codigo">
                        @if ($activo)
                            {{ $activo->categoria->name }}
                        @else
                            activo no encontrado
                        @endif
                    </td>

                    <td class="table-header">Codigo inventario:</td>
                    <td id="doc-codigo">
                        @if ($activo)
                            {{ $activo->id }}
                        @else
                            activo no encontrado
                        @endif
                    </td>
                    
                </tr>

                <tr>
                    <td class="table-header">Fabricante:</td>
                    <td id="doc-codigo">
                        @if ($activo)
                            {{ $activo->fabricante }}
                        @else
                            activo no encontrado
                        @endif
                    </td>
                    <td class="table-header">Modelo:</td>
                    <td id="doc-codigo">
                        @if ($activo)
                            {{ $activo->modelo }}
                        @else
                            activo no encontrado
                        @endif
                    </td>
                </tr>
                <td class="table-header">Color:</td>
                    <td id="doc-codigo">
                        @if ($activo)
                            {{ $activo->color }}
                        @else
                            activo no encontrado
                        @endif
                    </td>

                    <td class="table-header">Serie:</td>
                    <td id="doc-codigo">
                        @if ($activo)
                            {{ $activo->serie }}
                        @else
                            activo no encontrado
                        @endif
                    </td>

                <tr>

                </tr>
                <tr>
                    <td class="table-header">Personal Encargado:</td>
                    <td colspan="2" id="doc-usuario">
                        @if ($persona)
                            {{ $persona->nombre }}
                        @else
                            persona no encontrada
                        @endif
                    </td>
                </tr>
            </table>
            <br>
            <p>Diagnóstico</p>

            <table>
                <tr>
                    <td colspan="1" class="table-header">Problema:</td>
                    <td id="doc-detalle"></td>
                    <td colspan="1" class="table-header">Procedimiento:</td>
                    <td id="doc-prueba"></td>
                </tr>
            </table>
            <br>
            <p>Resultado</p>

            <table>
                <tr>
                    <td class="table-header">Conclusión:</td>
                    <td id="doc-conclusion"></td>
                </tr>
            </table>
        </div>
    </div>

    <style>
        .table-header {
            text-align: left;
            font-weight: bold;
            background-color: #4c70af;
            color: white;
        }

        /* Optional styling for the entire container */
        #vistaPrevia {
            padding: 10px;
            font-family: Arial, sans-serif;
            background-color: #ffd092aa;
            border-radius: 4px;
        }

        /* Styling for each table */
        table th,
        table td {
            padding: 10px 8px;
            text-align: center;
            vertical-align: middle;
        }
    </style>

    <script>
        function updatePreview(field) {
            // Obtener el valor de cada campo
            var problema = document.getElementById('problema').value;
            var prueba = document.getElementById('prueba').value;
            var conclusion = document.getElementById('conclusion').value;

            // Actualizar la vista previa en tiempo real
            document.getElementById('doc-detalle').innerText = problema;
            document.getElementById('doc-prueba').innerText = prueba;
            document.getElementById('doc-conclusion').innerText = conclusion;
        }
    </script>
</body>
@endsection
