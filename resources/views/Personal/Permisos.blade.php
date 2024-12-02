<!-- LLAMO AL APP DONDE ESTA MI CABECERA -->
@extends('Layout.app')
<!-- LLAMO AL SILDEBAR  -->
@extends('Componentes.silderbar')

<!-- AGREGO EL TITULO -->
@section('titulo', 'PERMISO')

<!-- AGREGO EL CONTENIDO DE ESTA VENTANA -->
@section('contenido')

    <link rel="stylesheet" href="css/permiso.css">
    <body>
        <button id="openModalBtn">Abrir Roles y Permisos</button>

        <div id="modal" class="overlay">
            <div  id="modal" class="overlay">
                <h2>ROLES Y PERMISOS</h2>
                <form action="guardar_permisos.php" method="post">
                    <div class="section">
                        <h3>ACCIONES:</h3>
                        <label>
                            ELIMINAR
                            <input type="checkbox" name="eliminar" id="eliminar">
                        </label>
                        <label>
                            EDITAR
                            <input type="checkbox" name="editar" id="editar">
                        </label>
                        <label>
                            AGREGAR
                            <input type="checkbox" name="agregar" id="agregar">
                        </label>
                        <label>
                            DESCARGAR
                            <input type="checkbox" name="descargar" id="descargar">
                        </label>
                    </div>
                    <div class="section">
                        <h3>VISTAS:</h3>
                        <label>
                            COMPLETO
                            <input type="checkbox" name="completo" id="completo">
                        </label>
                        <label>
                            ESPECIFICO
                            <input type="checkbox" name="especifico" id="especifico">
                        </label>
                    </div>
                    <button type="submit">GUARDAR</button>
                </form>
            </div>
        </div>
        <script src="js/permiso.js"></script>
    </body>

@endsection
