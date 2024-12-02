<!-- LLAMO AL APP DONDE ESTA MI CABECERA -->
@extends('Layout.app')
<!-- LLAMO AL SILDEBAR  -->
@extends('Componentes.silderbar')

<!-- AGREGO EL TITULO -->
@section('titulo', 'ACTIVOS')

<!-- AGREGO EL CONTENIDO DE ESTA VENTANA -->
@section('contenido')
    <div class="header">
        <h1>LISTA DE ACTIVOS</h1>
        <div class="search-container">
            <a href="{{ route('activo') }}" class="btnRegistro">REGISTRAR</a>
        </div>
    </div>
    <div class="search-bar">
        <form action="{{ route('buscar.activos') }}" method="POST">
            @csrf
            <div class="search-container">

                <input type="text" name="id" id="id" placeholder="CÓDIGO INVENTARIO">
                <button type="submit"> <i class="bi bi-search"></i></button>
                <a href="{{ route('lista.activos') }}" class="search-icon">Todos</a>
            </div>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>CÓDIGO INVENTARIO</th>
                    <th>CATEGORIA</th>
                    <th>FECHA INGRESO</th>
                    <th>FECHA COMPRA</th>
                    <th>FRABRICANTE</th>
                    <th>MODELO</th>
                    <th>SERIE</th>
                    <th>VALOR</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activos as $item)
                    <tr>
                        <td>{{ $item->id }}</th>
                        <td>{{ $item->categoria->name }}</td>
                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                        <td>{{ $item->fechacompra }}</td>
                        <td>{{ $item->fabricante }}</td>
                        <td>{{ $item->modelo }}</td>
                        <td>{{ $item->serie }}</td>
                        <td>S/{{ $item->valor }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
