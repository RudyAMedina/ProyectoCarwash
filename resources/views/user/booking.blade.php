<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reservar') }}
        </h2>
    </x-slot>
    <!-- Estilo para el datepicker -->
   
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div x-data="{ showModal: false }" class="container mx-auto px-4 py-8 max-w-3xl">
                        <!-- Encabezado -->
                        <div class="text-center mb-8">
                            <h1 class="text-3xl font-bold text-gray-800 mb-2">Nueva Reserva</h1>
                            <p class="text-gray-600">Complete los detalles de su reserva a continuación</p>
                        </div>

                        <!-- Tarjeta del formulario -->
                        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
                            <form method="POST" action="{{ route('bookings.store') }}" class="p-6 md:p-8">
                                @csrf
                                
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

                                <!-- Sección de usuario -->
                                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">Reservando como:</h3>
                                    <p class="text-lg font-semibold text-gray-900">{{ auth()->user()->email }}</p>
                                    <input hidden name="user_id" value="{{ auth()->user()->id }}">
                                </div>

                                <!-- Campos del formulario -->
                                <div class="space-y-6">
                                    <!-- Servicio -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Servicio</label>
                                        <select name="service_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md border">
                                            <option value="">-- Selecciona un servicio --</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">
                                                    {{ $service->name }} - ${{ number_format($service->price, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Marca y Modelo -->
                                    <div x-data="vehicleForm()" x-init="init" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <!-- Marca -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Marca</label>
                                            <select 
                                                name="marca_id" 
                                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md border"
                                                x-model="selectedBrand" 
                                                @change="fetchModels" 
                                                required
                                            >
                                                <option value="">-- Selecciona una marca --</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Modelo -->
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Modelo</label>
                                            <select 
                                                name="vehicle_model_id" 
                                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md border"
                                                required
                                            >
                                                <option value="">-- Selecciona un modelo --</option>
                                                <template x-for="model in models" :key="model.id">
                                                    <option :value="model.id" x-text="model.name"></option>
                                                </template>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Patente -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Patente</label>
                                        <input 
                                            type="text" 
                                            name="license_plate" 
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                            placeholder="Ej: AB123CD"
                                            required
                                        >
                                    </div>

                                    <!-- Fecha y Hora -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Fecha y Hora</label>
                                        <input 
                                            id="scheduled_at" 
                                            type="text" 
                                            name="scheduled_at" 
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"
                                            required
                                        >
                                    </div>

                                    <!-- Estado (oculto) -->
                                    <input type="hidden" name="status" value="pendiente">

                                    <!-- Botón de envío -->
                                    <div class="pt-6">
                                        <button 
                                            type="submit" 
                                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200"
                                        >
                                            Confirmar Reserva
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
            </div>    
        </div>
     </div>

     <script>
        const now = new Date();
        const oneHourLater = new Date(now.getTime() + 60 * 60 * 1000); // Hora actual +1

        flatpickr("#scheduled_at", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true,
            minuteIncrement: 60,
            minDate: now, // Permitir desde ahora
            maxTime: "16:00",
            defaultHour: oneHourLater.getHours(),
            defaultMinute: 0,

            onReady: function(selectedDates, dateStr, instance) {
                // Establece minTime solo si la fecha es hoy
                const today = now.toDateString();
                const selectedDay = instance.selectedDates[0]?.toDateString();

                if (today === selectedDay) {
                    const hour = oneHourLater.getHours();
                    instance.set('minTime', `${hour < 10 ? '0' : ''}${hour}:00`);
                } else {
                    instance.set('minTime', "09:00");
                }
            },

            onChange: function(selectedDates, dateStr, instance) {
                const selectedDate = selectedDates[0];
                const today = new Date();
                const selectedDay = selectedDate?.toDateString();

                if (selectedDay === today.toDateString()) {
                    const nextHour = new Date();
                    nextHour.setHours(nextHour.getHours() + 1);
                    instance.set('minTime', `${nextHour.getHours()}:00`);
                } else {
                    instance.set('minTime', "09:00");
                }
            }
        });
    </script>
    <script>
        function vehicleForm() {
            return {
                selectedBrand: '',
                models: [],
                init() {
                    // Opcional: cargar modelos si ya hay una marca seleccionada
                    if (this.selectedBrand) {
                        this.fetchModels();
                    }
                },
                fetchModels() {
                    if (!this.selectedBrand) {
                        this.models = [];
                        return;
                    }

                    fetch(`/api/models/${this.selectedBrand}`)
                        .then(response => response.json())
                        .then(data => {
                            this.models = data;
                        })
                        .catch(error => {
                            console.error("Error cargando modelos:", error);
                            this.models = [];
                        });
                }
            };
        }
    </script>
    
</x-app-layout>