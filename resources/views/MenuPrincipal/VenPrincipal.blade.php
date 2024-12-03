@extends('Layout.app')
@extends('Componentes.silderbar')

@section('titulo', 'DASBOARD')

@section('contenido')
    <link rel="stylesheet" href="css/dasboard.css">

    <body>
        <div class="stats-container">
            <div class="stat">
                <h2>{{ $fichasAsignadas }}</h2>
                <div class="change">Fichas Asignadas</div>
            </div>
            <div class="stat">
                <h2>{{ $fichasDevueltas }}</h2>
                <div class="change">Fichas Devolucion</div>
            </div>
            <div class="stat">
                <h2>{{ $fichasPrestadas }}</h2>
                <div class="change">Fichas Prestamo</div>
            </div>
            <div class="stat">
                <h2>{{ $informesTecnicos }}</h2>
                <div class="change">Informes Técnicos</div>
            </div>
        </div>

        <div class="charts-container">
            <div class="chart">
                <canvas id="barChart"></canvas>
            </div>
            <div class="chart">
                <canvas id="pieChart"></canvas>
            </div>
            <div class="chart">
                <canvas id="barChartH"></canvas>
            </div>
        </div>
    </body>

    <!-- Primero cargamos Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const barCtx = document.getElementById('barChart').getContext('2d');
            const barChart = new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: @json($incidenciasPorArea->pluck('area')->toArray()), // Nombres de
                    datasets: [{
                            label: 'Abiertas',
                            data: @json($incidenciasPorArea->pluck('abiertas')->toArray()), // Datos de incidencias abiertas
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'En Proceso',
                            data: @json($incidenciasPorArea->pluck('enProceso')->toArray()), // Datos de incidencias en proceso
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Cerradas',
                            data: @json($incidenciasPorArea->pluck('cerradas')->toArray()), // Datos de incidencias cerradas
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true, // Asegura que el eje Y comienza desde cero
                            ticks: {
                                // Opciones para los ticks (marcas) del eje Y
                                stepSize: 1, // Define que el paso entre las marcas sea de 1
                                callback: function(value) {
                                    // Redondear a entero
                                    return value % 1 === 0 ? value : ''; // Solo mostrar números enteros
                                }
                            }
                        }
                    }
                }
            });


            const pieCtx = document.getElementById('pieChart').getContext('2d');

            const pieChart = new Chart(pieCtx, {
                type: 'pie',
                data: {
                    labels: ['Operativos', 'No Operativos', 'Mantenimiento'],
                    datasets: [{
                        label: 'Total de Activos por Estado',
                        data: [@json($activosPorEstado['Operativos']), @json($activosPorEstado['No Operativos']),
                            @json($activosPorEstado['Mantenimiento'])
                        ],
                        backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)'
                        ],
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });

            const barCtxH = document.getElementById('barChartH').getContext('2d');
            const barChartH = new Chart(barCtxH, {
                type: 'bar', // Tipo de gráfico de barras
                data: {
                    labels: @json($activosPorPrecio->pluck('nombre')->toArray()), // Nombres de los activos
                    datasets: [{
                        label: 'Ranking de Precios de Activos',
                        data: @json($activosPorPrecio->pluck('valor')->toArray()), // Precios de los activos
                        backgroundColor: 'rgba(54, 162, 235, 0.7)', // Color de las barras33
                        borderColor: 'rgba(54, 162, 235, 1)', // Borde de las barras 3
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            beginAtZero: true, // Asegura que el eje X comienza desde cero3
                        },
                        y: {
                            beginAtZero: true, // Asegura que el eje Y comienza desde cero
                            position: 'left', // Coloca el eje Y a la izquierda
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(tooltipItem) {
                                    // Mostrar el valor y modelo del activo en TOLLTIP
                                    const nombre = tooltipItem.label;
                                    const valor = tooltipItem
                                        .raw; // El valor que está representado en la barra
                                    const modelo = @json($activosPorPrecio->pluck('modelo')->toArray())[tooltipItem
                                        .dataIndex]; // Obtener el modelo correspondiente
                                    return `${nombre} - Modelo: ${modelo} - Valor: $${valor}`;
                                }
                            }
                        }
                    }
                }
            });

        });
    </script>

@endsection
