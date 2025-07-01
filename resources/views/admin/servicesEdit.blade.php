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
                                <h1 class="text-2xl font-bold mb-4">Modificar Servicio</h1>
                                <div class="w-full max-w-7xl mx-auto px-4 overflow-x-auto">
                                    <form action="{{ route('services.update', $service->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium">Nombre</label>
                                            <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ old('name', $service->name) }}" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium">Descripción</label>
                                            <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description', $service->description) }}</textarea>                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium">Precio</label>
                                            <input type="number" name="price" step="0.01" class="w-full border rounded px-3 py-2" value="{{ old('price', $service->price) }}" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium">Duración (min)</label>
                                            <input type="number" name="duration_minutes" class="w-full border rounded px-3 py-2" value="{{ old('duration_minutes', $service->duration_minutes) }}" required>
                                        </div>
                                        <div class="flex justify-end">
                                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                                Actualizar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                </div>    
            </div>
                        
                        
        </div>
     </div>
 
    

</x-app-layout>