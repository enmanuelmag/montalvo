<x-admin-layout>
    @push('styles')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css">
    @endpush

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

            <!-- Tarjeta: Total Ventas -->
            @include('dashboard.partials.card', [
                'title' => 'Total Ventas',
                'value' => '$' . number_format($stats['total_ventas'], 2),
                'iconColor' => 'bg-green-500',
                'iconPath' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'subtitle' => "+{$stats['incremento_ventas']}% vs mes anterior",
                'subtitleColor' => 'text-green-500'
            ])

            <!-- Estudiantes Activos -->
            @include('dashboard.partials.card', [
                'title' => 'Estudiantes Activos',
                'value' => $stats['total_estudiantes'],
                'iconColor' => 'bg-blue-500',
                'iconPath' => 'M13 7a4 4 0 11-8 0 4 4 0 018 0z M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197',
                'subtitle' => "+{$stats['nuevos_estudiantes']} nuevos este mes",
                'subtitleColor' => 'text-blue-500'
            ])

            <!-- Cursos Activos -->
            @include('dashboard.partials.card', [
                'title' => 'Cursos Activos',
                'value' => $stats['cursos_activos'],
                'iconColor' => 'bg-yellow-500',
                'iconPath' => 'M12 6.253v13M12 6.253C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13M12 6.253C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13',
                'subtitle' => "{$stats['completados_mes']} completados este mes",
                'subtitleColor' => 'text-yellow-500'
            ])

            <!-- Pagos Pendientes -->
            @include('dashboard.partials.card', [
                'title' => 'Pagos Pendientes',
                'value' => $stats['pagos_pendientes'],
                'iconColor' => 'bg-red-500',
                'iconPath' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
                'subtitle' => '$' . number_format($stats['monto_pendiente'], 2) . ' por cobrar',
                'subtitleColor' => 'text-red-500'
            ])
        </div>

        <!-- Gráficos -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Ventas Mensuales</h3>
                <div id="ventasChart"></div>
            </div>

           <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Estudiantes por Curso</h3>
            <div id="estudiantesChart" style="width: 100%; max-width: 600px; margin: 0 auto;"></div>
        </div>
        </div>

        <!-- Actividad reciente -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Actividad Reciente</h3>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($stats['actividad_reciente'] as $actividad)
                    <li class="py-4 flex items-start space-x-4">
                        <span class="p-2 rounded-full" style="background-color: {{ $actividad['color'] }}">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $actividad['icon'] !!}
                            </svg>
                        </span>
                        <div>
                            <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ $actividad['titulo'] }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $actividad['descripcion'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $actividad['tiempo'] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @push('scripts')
       <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.44.2/dist/apexcharts.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
    if (window.ApexCharts) {
        // FIX: Deshabilita el almacenamiento para evitar el error t.put
        ApexCharts.exec = function () {};
        ApexCharts.memoryCache = false;
    }

    const ventasChart = new ApexCharts(document.querySelector("#ventasChart"), {
        series: [{
            name: "Ventas",
            data: @json($stats['ventas_mensuales']['valores'])
        }],
        chart: {
            type: 'area',
            height: 350,
            toolbar: { show: false },
            animations: {
                enabled: true
            }
        },
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' },
        xaxis: { categories: @json($stats['ventas_mensuales']['meses']) },
        tooltip: {
            y: {
                formatter: function (val) {
                    return "$" + val.toLocaleString()
                }
            }
        }
    });

    ventasChart.render();


    const estudiantesChart = new ApexCharts(document.querySelector("#estudiantesChart"), {
        series: @json($stats['estudiantes_por_curso']['valores']),
        chart: {
            type: 'donut',
            height: 400
        },
        labels: @json($stats['estudiantes_por_curso']['cursos']),
        legend: {
            position: 'bottom',
            horizontalAlign: 'center',
            fontSize: '14px',
            markers: {
                width: 12,
                height: 12,
                radius: 12,
                offsetX: -2
            },
            itemMargin: {
                horizontal: 10,
                vertical: 5
            }
        },
        dataLabels: {
            enabled: true,
            formatter: function (val, opts) {
                return val.toFixed(1) + "%";
            },
            style: {
                fontSize: '13px'
            }
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + " estudiante(s)";
                }
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    height: 300
                },
                legend: {
                    fontSize: '12px'
                }
            }
        }]
    });

    estudiantesChart.render();

});
        </script>
    @endpush
</x-admin-layout>