@section('silderbar')
<div class="sidebar">
    <ul>
        <!-- Botón de navegación para expandir o comprimir el sidebar -->
        <li class="navegar" id="toggleBtn">☰</li>
        
        <!-- Opción de Panel de Control -->
        <li class="teContro">
            <a href="{{ route('principal') }}">
                <i class="bi bi-grid-fill"></i>
                <span>PANEL</span>
            </a>
        </li>
        
        <!-- Opción de Control de Activos -->
        <li class="option users-option">
            <a href="javascript:void(0);" id="controlActivoBtn">
                <i class="bi bi-clipboard-check"></i>
                <span>CONTROL ACTIVO</span>
            </a>
        </li>
        
        <!-- Submenú de Control de Activos -->
        <ul class="submenu" id="submenu">
            @if ((Auth::check() && Auth::user()->id_area == 1) || Auth::user()->id_area == 3)
                <li class="submenu-option"><a href="{{ route('ficha') }}"><span>Ficha Solicitud</span></a></li>
                <li class="submenu-option"><a href="{{ route('informe') }}"><span>Informe Técnico</span></a></li>
            @endif

            @if ((Auth::check() && Auth::user()->id_area == 1) || Auth::user()->id_area == 2)
                <li class="submenu-option"><a href="{{ route('lista.activos') }}"><span>Lista de Activos</span></a></li>
                <li class="submenu-option"><a href="{{ route('lista.categoria') }}"><span>Lista de Categorias</span></a></li>
            @endif
        </ul>
        
        <!-- Opción de Reporte -->
        <li class="option">
            <a href="{{ route('reporte') }}">
                <i class="bi bi-bar-chart-line"></i>
                <span>REPORTE</span>
            </a>
        </li>
        
        <!-- Opción de Incidencia -->
        <li class="option">
            <a href="{{ route('ListaIncidencia') }}">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span>INCIDENCIA</span>
            </a>
        </li>
        
        <!-- Opción de Personal, visible solo para el área 1 -->
        @if (Auth::check() && Auth::user()->id_area == 1)
            <li class="option">
                <a href="{{ route('personal') }}">
                    <i class="bi bi-person-circle"></i>
                    <span>PERSONAL</span>
                </a>
            </li>
        @endif
        
        <!-- Opción para cerrar sesión -->
        <li class="option">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button>
                    <i class="bi bi-x-circle-fill"></i>
                    <span>CERRAR SESIÓN</span>
                </button>
            </form>
        </li>
    </ul>
</div>

@endsection
