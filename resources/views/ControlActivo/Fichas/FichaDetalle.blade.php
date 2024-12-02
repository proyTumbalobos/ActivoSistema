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
            <h1>ACTIVOS DE FICHA DE: {{$ficha->persona->nombre}}</h1>
            
            <div class="buttons">
                <a href="{{ route('activo') }}" class="btn-opcion">INGRESAR</a>
            </div>
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
                        <th>OPCIONES</th>
                    </tr>
                </thead>
                @foreach ($activos as $item)
                    <tr>
                        <th>{{$item->id}}</th>
                        <th>{{$item->categoria->name}}</th>
                        <th>{{$item->created_at->format('Y-m-d')}}</th>
                        <th>{{$item->fechacompra}}</th>
                        <th>{{$item->fabricante}}</th>
                        <th>{{$item->modelo}}</th>
                        <th>{{$item->serie}}</th>
                        <th>S/{{$item->valor}}</th>

                    </tr>
                @endforeach
            </table>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
       <script src="js/DocTabla.js"></script>

    </body>
@endsection