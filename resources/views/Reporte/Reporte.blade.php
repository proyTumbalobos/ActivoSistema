<!-- LLAMO AL APP DONDE ESTA MI CABECERA -->
@extends('Layout.app')
<!-- LLAMO AL SILDEBAR  -->
@extends('Componentes.silderbar')

<!-- AGREGO EL TITULO -->
@section('titulo', 'REPORTE')

<!-- AGREGO EL CONTENIDO DE ESTA VENTANA -->
@section('contenido')
    <div class="header">
        <h1>REPORTE DOCUMENTAL</h1>
    </div>

    <div class="search-bar">
        <form method="POST" action="{{ route('reporte.buscar') }}">
            @csrf
            <div class="search-container" style=" gap: 30px;">
                <input type="date" name="fecha_inicio" class="fecha" value="{{ request('fecha_inicio') }}">
                <input type="date" name="fecha_fin" class="fecha" value="{{ request('fecha_fin') }}" id="fecha_fin">

                <!-- Agregamos la opción de filtro por tipo de ficha -->
                <select name="filtro" class="filtro">
                    <option value="">Seleccionar filtro</option>
                    @foreach ($tiposFicha as $tipo)
                        <option value="{{ $tipo->nombre }}" {{ request('filtro') == $tipo->nombre ? 'selected' : '' }}>
                            {{ $tipo->nombre }}
                        </option>
                    @endforeach
                    <option value="Informe tecnico" {{ request('filtro') == 'Informe tecnico' ? 'selected' : '' }}>
                        Informe Técnico
                    </option>
                </select>

                <button type="submit">
                    <i class="bi bi-search"></i> <!-- Icono de lupa -->
                </button>
            </div>
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

        </form>
    </div>

    <div class="column-right">
        <!-- Panel de gestión de columnas -->
        <div class="column-management">
            <div class="column-header">
                <h3>SELECCIONA LAS COLUMNAS PARA TU REPORTE</h3>
                <button class="download-btn" onclick="descargarReporte()">Descargar</button>
            </div>

            @foreach (['codigo' => 'CÓDIGO FICHA', 'tipo_ficha' => 'TIPO FICHA', 'fecha_ingreso' => 'FECHA INGRESO', 'personal' => 'PERSONAL', 'tipo_equipo' => 'TIPO EQUIPO','codigo_inventario' => 'CODIGO INVENTARIO','modelo' => 'MODELO','serie' => 'SERIE', 'area' => 'ÁREA', 'sede' => 'SEDE'] as $column => $label)
                <label><input type="checkbox" name="columns" value="{{ $column }}" checked>
                    {{ $label }}</label>
            @endforeach
        </div>
    </div>


    <!-- Tabla de reporte -->
    <div class="table-container">
        <table id="reporteTable">
            <thead>
                <tr>
                    <th data-column="codigo">CÓDIGO FICHA</th>
                    <th data-column="tipo_ficha">TIPO FICHA</th>
                    <th data-column="fecha_ingreso">FECHA INGRESO</th>
                    <th data-column="personal">PERSONAL</th>
                    <th data-column="tipo_equipo">TIPO EQUIPO</th>
                    <th data-column="codigo_inventario">CODIGO INVENTARIO</th>
                    <th data-column="modelo">MODELO</th>
                    <th data-column="serie">SERIE</th>
                    <th data-column="area">ÁREA</th>
                    <th data-column="sede">SEDE</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($fichas as $item)
                    @foreach ($item->activos as $activo)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->tipo->nombre }}</td>
                            <td>{{ $item->created_at->format('Y-m-d') }}</td>
                            <td>{{ $item->persona->nombre }}</td>
                            <td>{{ $activo->categoria->name }}</td>
                            <td>{{ $activo->id }}</td>
                            <td>{{ $activo->modelo }}</td>
                            <td>{{ $activo->serie }}</td>
                            <td>{{ $item->persona->area->nombre }}</td>
                            <td>{{ $item->persona->sede->nombre }}</td>
                        </tr>
                    @endforeach
                @endforeach

                @foreach ($informes as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>Informe técnico</td>
                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                        <td>{{ $item->persona->nombre }}</td>
                        <td>{{ $item->activo->categoria->name }}</td>
                        <td>{{ $item->activo->id }}</td>
                        <td>{{ $item->activo->modelo }}</td>
                        <td>{{ $item->activo->serie }}</td>
                        <td>{{ $item->persona->area->nombre }}</td>
                        <td>{{ $item->persona->sede->nombre }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
    <script src="{{ asset('js/reporte.js') }}"></script>
@endsection
