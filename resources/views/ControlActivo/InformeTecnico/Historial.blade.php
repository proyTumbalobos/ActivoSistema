<!-- LLAMO AL APP DONDE ESTA MI CABECERA -->
@extends('Layout.app')
<!-- LLAMO AL SILDEBAR  -->
@extends('Componentes.silderbar')

<!-- AGREGO EL TITULO -->
@section('titulo', 'PRINCIPAL')

<!-- AGREGO EL CONTENIDO DE ESTA VENTANA -->
@section('contenido')
    <link rel="stylesheet" href="css/Menu.css">

    <body>
        <div class="header">
            <h1>CODIGO INVENTARIO</h1>
            <div class="buttons">
                <a href="{{ route('crearFicha') }}" class="btn-opcion">INGRESAR</a>
            </div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>CÓDIGO INVENTARIO</th>
                        <th>TIPO FICHA</th>
                        <th>FECHA INGRESO</th>
                        <th>PERSONAL</th>
                        <th>TIPO EQUIPO</th>
                        <th>ÁREA</th>
                        <th>SEDE</th>
                        <th>OPCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Datos simulados
                    $data = [
                        ['4871526', 'Asignación', '1/05/2018', 'Tito', 'Laptop', 'TI', 'Dasso'],
                        ['4871527', 'Devolución', '7/10/2023', 'Gustavo', 'PC-Dekstop', 'Contabilidad', 'Dasso'],
                        ['4871528', 'Préstamo', '8/10/2023', 'Alejandra', 'Laptop', 'Ingeniero', 'Planta'],
                        ['4871529', 'Asignación', '9/10/2023', 'Donatello', 'Mouse', 'Gerencia de Mantenimiento', 'Dasso'],
                        ['4871530', 'Préstamo', '10/10/2023', 'Dayana', 'Cargador', 'Gerencia de Mantenimiento', 'Dasso'],
                        ['4871529', 'Asignación', '9/10/2023', 'Donatello', 'Mouse', 'Gerencia de Mantenimiento', 'Dasso'],
                        ['4871530', 'Préstamo', '10/10/2023', 'Dayana', 'Cargador', 'Gerencia de Mantenimiento', 'Dasso'],
                        ['4871529', 'Asignación', '9/10/2023', 'Donatello', 'Mouse', 'Gerencia de Mantenimiento', 'Dasso'],
                        ['4871530', 'Préstamo', '10/10/2023', 'Dayana', 'Cargador', 'Gerencia de Mantenimiento', 'Dasso'],
                        ['4871529', 'Asignación', '9/10/2023', 'Donatello', 'Mouse', 'Gerencia de Mantenimiento', 'Dasso'],
                        ['4871530', 'Préstamo', '10/10/2023', 'Dayana', 'Cargador', 'Gerencia de Mantenimiento', 'Dasso'],
                        ['4871529', 'Asignación', '9/10/2023', 'Donatello', 'Mouse', 'Gerencia de Mantenimiento', 'Dasso'],
                        ['4871531', 'Asignación', '11/10/2023', 'Dante', 'Monitor', 'Ingeniero', 'Planta'],
                    ];
                    
                    $start = 0;
                    $limit = 15;
                    $totalRows = count($data);
                    $totalPages = ceil($totalRows / $limit);
                    $page = isset($_GET['page']) ? $_GET['page'] : 1;
                    $start = ($page - 1) * $limit;
                    
                    // Paginar los datos simulados
                    $pageData = array_slice($data, $start, $limit);
                    
                    foreach ($pageData as $row) {
                        echo '<tr>';
                        foreach ($row as $cell) {
                            echo "<td>{$cell}</td>";
                        }
                        echo "<td>
                                <button class='btn btn-ver' onclick='openModal(".json_encode($row).")'>Ver</button>
                                <button class='btn btn-descargar' onclick='downloadPDF(".json_encode($row).")'>Descargar</button>
                             </td>";
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="pagination">
            <?php if($page > 1): ?>
            <a href="?page=<?php echo $page - 1; ?>">Anterior</a>
            <?php endif; ?>
            <?php if($page < $totalPages): ?>
            <a href="?page=<?php echo $page + 1; ?>">Siguiente</a>
            <?php endif; ?>
        </div>
        <div class="row-count">
            Mostrando <?php echo $start + 1; ?> a <?php echo min($start + $limit, $totalRows); ?> de <?php echo $totalRows; ?> filas
        </div>

        <!-- Modal para mostrar datos -->
        <div id="modal" class="modal">
            <div class="modal-content">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <h2>Detalles de la Fila</h2>
                <p id="modal-content"></p>
                <button id="btn-descargar" onclick="downloadPDF()">Descargar PDF</button>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
       <script src="js/DocTabla.js"></script>

    </body>
@endsection
