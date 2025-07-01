<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel') }}
        </h2>
    </x-slot>
    <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Contenedor con altura fija -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8" style="min-height: 350px;">
                    <!-- Gráfico de Usuarios -->
                    <div class="relative">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Registro de Usuarios</h3>
                        <canvas id="userChart" height="300" width="400"></canvas>
                        <div id="userChartLoader" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-80 hidden">
                            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div>
                        </div>
                    </div>
                    
                    <!-- Gráfico de Reservas -->
                    <div class="relative">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Tendencias de Reservas</h3>
                        <canvas id="reservaChart" height="300" width="400"></canvas>
                        <div id="reservaChartLoader" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-80 hidden">
                            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-pink-500"></div>
                        </div>
                    </div>
                </div>

                <script>
                    // Verificar datos primero
                    document.addEventListener('DOMContentLoaded', function() {
                        const months = @json($months ?? []);
                        const userCounts = @json($userCounts->values() ?? []);
                        const reservaCounts = @json($reservaCounts->values() ?? []);

                        // Mostrar loaders
                        document.getElementById('userChartLoader').classList.remove('hidden');
                        document.getElementById('reservaChartLoader').classList.remove('hidden');

                        // Verificar si hay datos
                        if(months.length === 0 || userCounts.length === 0 || reservaCounts.length === 0) {
                            console.error("Datos faltantes para los gráficos");
                            return;
                        }

                        // Destruir gráficos anteriores si existen
                        if(window.userChartInstance) {
                            window.userChartInstance.destroy();
                        }
                        if(window.reservaChartInstance) {
                            window.reservaChartInstance.destroy();
                        }

                        try {
                            // Gráfico de Usuarios
                            window.userChartInstance = new Chart(
                                document.getElementById('userChart').getContext('2d'), 
                                {
                                    type: 'bar',
                                    data: {
                                        labels: months,
                                        datasets: [{
                                            label: 'Usuarios Registrados',
                                            data: userCounts,
                                            backgroundColor: 'rgba(0, 123, 255, 0.7)'
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        animation: {
                                            duration: 1000,
                                            onComplete: () => {
                                                document.getElementById('userChartLoader').classList.add('hidden');
                                            }
                                        }
                                    }
                                }
                            );

                            // Gráfico de Reservas
                            window.reservaChartInstance = new Chart(
                                document.getElementById('reservaChart').getContext('2d'), 
                                {
                                    type: 'line',
                                    data: {
                                        labels: months,
                                        datasets: [{
                                            label: 'Reservas Realizadas',
                                            data: reservaCounts,
                                            borderColor: 'rgba(236, 72, 153, 1)'
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        animation: {
                                            duration: 1000,
                                            onComplete: () => {
                                                document.getElementById('reservaChartLoader').classList.add('hidden');
                                            }
                                        }
                                    }
                                }
                            );

                        } catch (error) {
                            console.error("Error al renderizar gráficos:", error);
                            document.getElementById('userChartLoader').classList.add('hidden');
                            document.getElementById('reservaChartLoader').classList.add('hidden');
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>
    
</x-app-layout>
