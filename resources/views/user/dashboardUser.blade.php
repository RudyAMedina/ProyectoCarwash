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
          
                        <div class="container mx-auto px-4 py-8">
                            <h1 class="text-3xl font-bold text-gray-800 mb-6">Mis Reservas</h1>
                            
                            <!-- Mensajes de estado -->

                            <!-- Mensaje de exito -->
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
                            <!-- Mensaje de error -->
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

                            @if($booking->isEmpty())
                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                                    <p class="text-blue-700">No tienes reservas registradas.</p>
                                </div>
                            @else
                                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                                    @foreach($booking as $bookings)
                                        <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                                            <!-- Encabezado con estado -->
                                            <div class="px-4 py-3 border-b flex justify-between items-center 
                                                @if($bookings->status == 'confirmado') bg-green-100 text-green-800
                                                @elseif($bookings->status == 'pendiente') bg-yellow-100 text-yellow-800
                                                @elseif($bookings->status == 'completado') bg-blue-100 text-blue-800
                                                @elseif($bookings->status == 'cancelado') bg-red-100 text-red-800
                                                @endif">
                                                <span class="font-semibold">{{ ucfirst($bookings->status) }}</span>
                                                <span class="text-sm">{{ \Carbon\Carbon::parse($bookings->scheduled_at)->format('d/m/Y H:i') }}</span>
                                            </div>

                                            <!-- Cuerpo de la tarjeta -->
                                            <div class="p-4">
                                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $bookings->service->name }}</h3>
                                                
                                                <div class="mb-3">
                                                    <p class="text-sm text-gray-600">Vehículo:</p>
                                                    <p class="font-medium">{{ $bookings->vehicleModel->brand->name }} {{ $bookings->vehicleModel->name }}</p>
                                                </div>

                                                <div class="mb-3">
                                                    <p class="text-sm text-gray-600">Placa:</p>
                                                    <p class="font-medium">{{ $bookings->license_plate }}</p>
                                                </div>

                                                <div class="mb-3">
                                                    <p class="text-sm text-gray-600">Fecha y hora:</p>
                                                    <p class="font-medium">{{ \Carbon\Carbon::parse($bookings->scheduled_at)->format('d/m/Y H:i') }}</p>
                                                </div>
                                            </div>

                                            <!-- Pie de tarjeta (opcional: botones de acción) -->
                                            <div class="px-4 py-3 bg-gray-50 border-t flex justify-end">
                                                <form action="{{ route('bookings.destroy', $bookings->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro que deseas cancelar la reserva?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    @if($bookings->status == 'pendiente')
                                                        <button type= "submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                                            Cancelar
                                                        </button>
                                                    @endif
                                                </form>    
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                 
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
