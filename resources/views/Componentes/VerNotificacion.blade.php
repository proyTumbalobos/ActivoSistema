<!-- resources/views/components/ver-notificacion.blade.php -->
<i class="bi bi-bell-fill" style="color:orange; font-size:25px" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight">
    @if ($incidenciasNoVistas->count() > 0)
        <span class="badge bg-danger"
            style="position: absolute; top: 12px; left: 670px; font-size: 12px; width: 20px; height: 20px; border-radius: 50%; text-align: center; display: flex; justify-content: center; align-items: center;">
            {{ $incidenciasNoVistas->count() }}
        </span>
    @endif
</i>

<!-- Offcanvas de notificaciones -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Notificaciones</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        @if ($incidenciasNoVistas->count() > 0)
            <!-- Mostrar las incidencias no vistas -->
            @foreach ($incidenciasNoVistas as $incidencia)
                @php
                    $tiempoTranscurrido = \Carbon\Carbon::parse($incidencia->fecha_ingreso)->diffForHumans();
                @endphp

                <div class="notification-item"
                    style="background-color: {{ $incidencia->visto ? 'transparent' : '#f8d7da' }};">
                    <p>
                        <strong>Área:</strong> {{ $incidencia->area->nombre }}<br>
                        <strong>Sede:</strong> {{ $incidencia->sede->nombre }}<br>
                        <strong>Hace:</strong> {{ $tiempoTranscurrido }}<br>
                    </p>
                    <!-- Enlace para redirigir a la incidencia y marcarla como vista -->
                    <a href="{{ route('marcarVistoYVer', $incidencia->id) }}" class="btn btn-link">Ver Incidencia</a>
                </div>
            @endforeach
        @else
            <p>No hay incidencias nuevas.</p>
        @endif
    </div>
</div>
