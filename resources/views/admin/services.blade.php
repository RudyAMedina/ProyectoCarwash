<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Servicios') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                        <div x-data="{ showModal: false }" class="container mx-auto px-4">
                            <h1 class="text-2xl font-bold mb-4">Lista de Servicios</h1>
                            <div class="mb-4 text-right">
                                <button @click="showModal = true"
                                    class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                    Agregar Servicio
                                </button>
                            </div>
                            <div>
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
                            </div>

                            <!-- Contenedor y tabla de servicios -->
                            <div class="w-full max-w-7xl mx-auto px-4 overflow-x-auto">
                                <table class="w-full table-auto bg-white border border-gray-300">
                                        <thead>
                                            <tr class="bg-gray-100">
                                                <th class="py-2 px-4 border">ID</th>
                                                <th class="py-2 px-4 border">Nombre</th>
                                                <th class="py-2 px-4 border">Descripción</th>
                                                <th class="py-2 px-4 border">Precio</th>
                                                <th class="py-2 px-4 border">Duración (min)</th>
                                                <th class="py-2 px-4 border">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($services as $service)
                                                <tr>
                                                    <td class="py-2 px-4 border">{{ $service->id }}</td>
                                                    <td class="py-2 px-4 border">{{ $service->name }}</td>
                                                    <td class="py-2 px-4 border">{{ $service->description }}</td>
                                                    <td class="py-2 px-4 border">${{ number_format($service->price, 2) }}</td>
                                                    <td class="py-2 px-4 border">{{ $service->duration_minutes }}</td>
                                                    <td class="py-2 px-4 border text-center">
                                                        <a href="{{ route('services.edit', $service->id) }}" class="text-blue-500 hover:underline mr-2">Editar</a>
                                                        <form action="{{ route('services.destroy', $service->id) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar este servicio?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-500 hover:underline">Eliminar</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="py-2 px-4 text-center text-gray-500">No hay servicios disponibles.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                               
                            </div>
                            
                            
                            <!-- Modal -->
                            <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
                                <div class="bg-white rounded-lg shadow-lg w-full sm:w-[500px] p-6">
                                    <div class="flex justify-between items-center mb-4">
                                        <h2 class="text-xl font-semibold">Agregar Servicio</h2>
                                        <button @click="showModal = false" class="text-gray-500 hover:text-gray-800">&times;</button>
                                    </div>

                                    <form method="POST" action="{{ route('services.store') }}">
                                        @csrf
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium">Nombre</label>
                                            <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium">Descripción</label>
                                            <textarea name="description" class="w-full border rounded px-3 py-2"></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium">Precio</label>
                                            <input type="number" name="price" step="0.01" class="w-full border rounded px-3 py-2" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium">Duración (min)</label>
                                            <input type="number" name="duration_minutes" class="w-full border rounded px-3 py-2" required>
                                        </div>
                                        <div class="flex justify-end">
                                            <button type="button" @click="showModal = false" class="bg-gray-300 text-black px-4 py-2 rounded mr-2">
                                                Cancelar
                                            </button>
                                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                                Guardar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>    
                        </div>
                        
                        
                </div>
            </div>
        </div>
    </div>
    

</x-app-layout>