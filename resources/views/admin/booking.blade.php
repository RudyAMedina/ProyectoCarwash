<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reservas') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <h1 class="text-2xl font-bold mb-4 text-center md:text-left">Lista de Citas</h1>
                        
                        <!-- Contenedor del formulario de busqueda-->
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">
                            <!-- Barra de búsqueda -->
                            <form method="GET" action="{{ route('admin.booking') }}" class="w-full md:w-auto">
                                <div class="relative w-full">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        placeholder="Buscar por patente, usuario o fecha..." 
                                        value="{{ request('search') }}"
                                        class="w-full py-2 px-4 pr-10 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                    >
                                    <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </form>
                            
                            <!-- Botón de limpiar, visible cuando hay una busqueda -->
                            @if(request('search'))
                                <a href="{{ route('admin.booking') }}" class="flex items-center justify-center md:justify-start text-gray-500 hover:text-gray-700 md:ml-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span class="ml-1 md:hidden">Limpiar</span>
                                </a>
                            @endif
                        </div>
                    </div>
                        <!-- Mensajes de estado -->
                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                                    </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        Hay {{ $errors->count() }} error(es) en tu envío
                                    </h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Contenedor y tabla para reservas -->
                    <div class="w-full max-w-7xl mx-auto px-4 overflow-x-auto">
                        <table class="w-full table-auto bg-white border border-gray-300">
                            <thead>
                                <tr class="bg-gray-100">
                                        <th class="py-2 px-4 border">ID</th>
                                        <th class="py-2 px-4 border">Usuario</th>
                                        <th class="py-2 px-4 border">Servicio</th>
                                        <th class="py-2 px-4 border">Modelo Vehículo</th>
                                        <th class="py-2 px-4 border">Patente</th>
                                        <th class="py-2 px-4 border">Fecha Agendada</th>
                                        <th class="py-2 px-4 border">Estado</th>
                                        <th class="py-2 px-4 border">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($booking as $bookings)
                                    <tr>
                                        <td class="py-2 px-4 border">{{ $bookings->id }}</td>
                                        <td class="py-2 px-4 border">{{ $bookings->user->name ?? 'N/A' }}</td>
                                        <td class="py-2 px-4 border">{{ $bookings->service->name ?? 'N/A' }}</td>
                                        <td class="py-2 px-4 border">{{ $bookings->vehicleModel->name ?? 'N/A' }}</td>
                                        <td class="py-2 px-4 border">{{ $bookings->license_plate }}</td>
                                        <td class="py-2 px-4 border">{{ \Carbon\Carbon::parse($bookings->scheduled_at)->format('d/m/Y H:i') }}</td>
                                        <td class="py-2 px-4 border capitalize">
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" 
                                                    class="sr-only peer" 
                                                    data-booking-id="{{ $bookings->id }}"
                                                    @if($bookings->status == 'completado') checked @endif
                                                    onchange="toggleStatus(this)">
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600">     
                                                </div>
                                                <span class="ml-3 text-sm font-medium text-gray-900">
                                                    {{ $bookings->status }}
                                                </span>
                                            </label>
                                        </td>
                                        <td class="py-2 px-4 border text-center">
                                            <form action="{{ route('booking.destroy', $bookings->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar esta cita?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="py-2 px-4 text-center text-gray-500">No hay citas disponibles.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>    
    </div>

    <script>
        function toggleStatus(checkbox) {
            const bookingId = checkbox.getAttribute('data-booking-id');
            const newStatus = checkbox.checked ? 'completado' : 'pendiente';
            
            fetch(`/admin/bookings/${bookingId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    status: newStatus
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al actualizar el estado');
                }
                return response.json();
            })
            .then(data => {
                // Actualizar el texto del estado
                const statusText = checkbox.nextElementSibling.nextElementSibling;
                statusText.textContent = newStatus;
                
                // Mostrar notificación
                Toastify({
                    text: `Estado cambiado a ${newStatus}`,
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#10B981",
                }).showToast();
            })
            .catch(error => {
                console.error('Error:', error);
                checkbox.checked = !checkbox.checked; // Revertir el cambio
                
                Toastify({
                    text: "Error al cambiar el estado",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#EF4444",
                }).showToast();
            });
        }

        </script>

</x-app-layout>