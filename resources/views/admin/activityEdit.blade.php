<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Publicaciones') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                                <h1 class="text-2xl font-bold mb-4">Modificar Publicación</h1>
                                <div class="w-full max-w-7xl mx-auto px-4 overflow-x-auto">
                                    <form action="{{ route('activity.update', $activity->id) }}" method="POST" enctype="multipart/form-data">                                        
                                        @csrf
                                        @method('PATCH')
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium">Titulo</label>
                                            <input type="text" name="title" class="w-full border rounded px-3 py-2" value="{{ old('title', $activity->title) }}" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium">Descripción</label>
                                            <textarea name="description" class="w-full border rounded px-3 py-2">{{ old('description', $activity->description) }}</textarea>   
                                        </div>
                                        <div class="mb-4">
                                            <!-- Mostrar imagen actual si existe -->
                                            @if ($activity->image_path)
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-600 mb-1">Imagen actual:</p>
                                                    <img src="{{ asset('images/' . $activity->image_path) }}" alt="Imagen actual" class="w-48 h-48 object-cover rounded shadow">
                                                </div>
                                            @endif

                                            <label class="block text-sm font-medium">Imagen</label>

                                            <input type="file" name="image_path" id="imageInput" accept="image/*" class="w-full border rounded px-3 py-2">
                                            
                                            @error('image_path')
                                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                            @enderror

                                            <!-- Contenedor para vista previa de la nueva imagen-->
                                            <div id="previewContainer" class="mt-4 hidden">
                                                <p class="text-sm text-gray-600 mb-1">Vista previa de la nueva imagen:</p>
                                                <img id="imagePreview" src="" class="w-48 h-48 object-cover rounded shadow">
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-sm font-medium">Fecha</label>
                                            <input type="date" name="activity_date" class="w-full border rounded px-3 py-2" value="{{ old('activity_date', $activity->activity_date) }}" required>
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
 
<script>
    document.getElementById('imageInput').addEventListener('change', function (event) {
        const file = event.target.files[0];
        const previewContainer = document.getElementById('previewContainer');
        const imagePreview = document.getElementById('imagePreview');

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };

            reader.readAsDataURL(file);
        } else {
            previewContainer.classList.add('hidden');
            imagePreview.src = '';
        }
    });
</script>

</x-app-layout>