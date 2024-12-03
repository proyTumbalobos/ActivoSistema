<!DOCTYPE html>
<html lang="es">

<head>
    <title>@yield('titulo', 'Sistema Control Activo')</title>

    <!-- Cargar estilo sistema -->
    <link rel="stylesheet" href="{{ asset('css/EstiloGeneral.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Principal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reporte.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Personal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ficha.css') }}">


    <!-- Cargar Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    
</head>

<body class="body">
    <header>
        <div class="header-container">
            <div class="user-info">
                <div class="img-contenedor">
                    <x-iniciar-notificacion />

                </div>
    
                <!-- BORDE BLANCO -->
                <div class="divider"></div>
    
                <!-- DATOS DEL USUARIO -->
                <div class="user-details">
                    <span>{{ Auth::user()->nombre }}</span>
                    <span>{{ Auth::user()->tipoPersona->nombre }}</span>
                </div>
    
                <div class="img-contenedor">
                    <img src="{{ asset('img/perfil.png') }}" alt="Perfil">
                </div>
            </div>
        </div>
    </header>

    
    </div>
    <!-- LLAMAR AL SILDERBAR PARA MIS OPCIONES  -->
    @yield('silderbar')

    <div class="main-content">
        @yield('contenido')
    </div>

    <footer></footer>
    <script src="{{ asset('js/silderbar.js') }}"></script>

    <!-- Cargar jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Cargar Bootstrap 5 (con Popper incluido) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</body>

</html>
