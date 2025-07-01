<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Carwash Temuco</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <script src="https://maps.googleapis.com/maps/api/js?key=" async defer></script>


        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
              
            </style>
        @endif
    </head>
    <body class="bg-blue-50 text-gray-800">
        <header x-data="{ open: false }" class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-4">
                        <a href="{{ url('/') }}">
                            <x-application-logo class="block h-9 w-auto fill-current text-blue-600" />
                        </a>

                        <a href="{{ url('/wall/activity') }}" class="flex-shrink-0 h-9">
                            <svg viewBox="0 0 120 36" xmlns="http://www.w3.org/2000/svg" class="h-full w-auto">
                                <rect width="120" height="36" fill="#3395FF" rx="8" ry="8"/>
                                <text x="60" y="22" font-family="Arial, sans-serif" font-size="14" fill="white" text-anchor="middle" font-weight="600">
                                    MURO
                                </text>
                                <circle cx="20" cy="12" r="3" fill="white" opacity="0.2"/>
                                <circle cx="30" cy="8" r="3.5" fill="white" opacity="0.4"/>
                                <circle cx="40" cy="12" r="3" fill="white" opacity="0.4"/>
                            </svg>
                        </a>
                    </div>

                    <!-- Botón y menú para móviles -->
                    <div class="relative md:hidden w-full flex justify-end">
                        <!-- Botón del menú -->
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <!-- Icono de hamburguesa (cuando el menú está cerrado) -->
                                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <!-- Icono de X (cuando el menú está abierto) -->
                                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <!-- Menú desplegable -->
                        <div
                            x-show="open"
                            @click.away="open = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute right-0 w-48 bg-white shadow-md rounded-lg p-4 z-50 mt-2"
                            style="top: calc(100% + 10px);"
                        >
                            @auth
                                <a href="{{ url('/dashboard') }}" class="block text-right px-4 py-2 text-black rounded-md hover:bg-[#3E3E3A]">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 12L10 7V10H3V14H10V17L15 12Z" fill="#007BFF"/>
                                        <path d="M14 3H19C20.1046 3 21 3.89543 21 5V19C21 20.1046 20.1046 21 19 21H14" stroke="#007BFF" stroke-width="2" stroke-linecap="round"/>
                                    </svg></a>
                            @else
                                <a href="{{ route('login') }}" class="block text-right px-4 py-2 text-black rounded-md hover:bg-[#007BFF]">Login</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="block text-right px-4 py-2 text-black rounded-md hover:bg-[#007BFF]">Registrarse</a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Menú para dispositivos grandes -->
                    <div class="hidden md:flex justify-end space-x-4">
                        <nav class="flex items-center justify-end gap-4">                    
                            @auth
                                <a
                                    href="{{ url('/dashboard') }}"
                                    class="inline-block px-5 py-1.5 border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#007BFF] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                                >
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15 12L10 7V10H3V14H10V17L15 12Z" fill="#007BFF"/>
                                        <path d="M14 3H19C20.1046 3 21 3.89543 21 5V19C21 20.1046 20.1046 21 19 21H14" stroke="#007BFF" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            @else
                                <a
                                    href="{{ route('login') }}"
                                    class="inline-block px-5 py-1.5  text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                                >
                                    Login
                                </a>

                                @if (Route::has('register'))
                                    <a
                                        href="{{ route('register') }}"
                                        class="inline-block px-5 py-1.5  text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal">
                                        Registrar
                                    </a>
                                @endif
                            @endauth
                        </nav>
                    </div>
                    
                </div>        
            </div>
        </header>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
                        <main class="w-full">
                            <!-- Carrusel de imágenes mejorado -->
                            <div class="relative group">
                                <div class="carousel-container relative w-full overflow-hidden rounded-t-lg">
                                    <div class="carousel-inner flex transition-transform duration-700 ease-in-out">
                                        <div class="carousel-item w-full flex-shrink-0">
                                            <img src="{{ asset('images/imagen1.jpeg') }}" alt="Imagen 1" class="w-full object-cover h-64 md:h-96 lg:h-[500px] xl:h-[600px]">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                                        </div>
                                        <div class="carousel-item w-full flex-shrink-0">
                                            <img src="{{ asset('images/imagen2.jpeg') }}" alt="Imagen 2" class="w-full object-cover h-64 md:h-96 lg:h-[500px] xl:h-[600px]">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                                        </div>
                                        <div class="carousel-item w-full flex-shrink-0">
                                            <img src="{{ asset('images/imagen3.jpeg') }}" alt="Imagen 3" class="w-full object-cover h-64 md:h-96 lg:h-[500px] xl:h-[600px]">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Botones de navegación mejorados -->
                                <button id="prev" class="absolute top-1/2 left-4 transform -translate-y-1/2 p-3 bg-white/30 hover:bg-white/50 text-white rounded-full backdrop-blur-sm transition-all duration-300 group-hover:opacity-100 opacity-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button id="next" class="absolute top-1/2 right-4 transform -translate-y-1/2 p-3 bg-white/30 hover:bg-white/50 text-white rounded-full backdrop-blur-sm transition-all duration-300 group-hover:opacity-100 opacity-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                                
                                <!-- Indicadores de posición -->
                                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                    <div class="w-3 h-3 rounded-full bg-white/50 hover:bg-white cursor-pointer dot-indicator"></div>
                                    <div class="w-3 h-3 rounded-full bg-white/50 hover:bg-white cursor-pointer dot-indicator"></div>
                                    <div class="w-3 h-3 rounded-full bg-white/50 hover:bg-white cursor-pointer dot-indicator"></div>
                                </div>
                            </div>

                            <!-- Hero section -->
                            <section class="bg-gradient-to-r from-blue-600 to-blue-800 py-20 text-center text-white">
                                <div class="container mx-auto px-4">
                                    <h2 class="text-4xl md:text-5xl font-bold mb-6 animate-fade-in">¡Dale brillo a tu auto con Carwash Temuco!</h2>
                                    <p class="text-xl mb-8 max-w-2xl mx-auto">Reservas fáciles, servicio rápido y de calidad profesional.</p>
                                    <a href="{{ Auth::check() ? route('user.booking') : route('login') }}" 
                                    class="inline-block bg-white text-blue-600 hover:bg-gray-100 px-8 py-4 rounded-lg font-semibold text-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                                    Reserva Ahora
                                    </a>
                                </div>
                            </section>

                            <!-- Servicios mejorados -->
                            <section id="servicios" class="py-20 bg-gray-50">
                                <div class="container mx-auto px-4">
                                    <h3 class="text-3xl font-bold text-center mb-16 relative inline-block">
                                        Nuestros Servicios
                                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-blue-500"></span>
                                    </h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                        @foreach($services as $service)
                                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                                            <div class="h-48 bg-blue-500 flex items-center justify-center">
                                                <!-- Icono diferente para cada servicio -->
                                                @switch($loop->index % 3)
                                                    @case(0)
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                        </svg>
                                                        @break
                                                    @case(1)
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                                        </svg>
                                                        @break
                                                    @case(2)
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                                        </svg>
                                                        @break
                                                @endswitch
                                            </div>
                                            <div class="p-6">
                                                <h4 class="text-xl font-semibold mb-3">{{ $service->name }}</h4>
                                                <p class="text-gray-600">{{ $service->description ?? 'Descripción no disponible' }}</p>
                                                <div class="mt-4 text-blue-600 font-medium">
                                                    Desde ${{ number_format($service->price, 0, ',', '.') }}
                                                </div>
                                                @if($service->duration_minutes)
                                                    <div class="mt-2 text-sm text-gray-500">
                                                        Duración: {{ $service->duration_minutes }} minutos
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                            

                            <!-- Ubicación mejorada -->
                            <section id="ubicacion" class="py-16 bg-white">
                                <div class="container mx-auto px-4">
                                    <h3 class="text-3xl font-bold text-center mb-16 relative inline-block">
                                        Nuestra Ubicación
                                        <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-16 h-1 bg-blue-500"></span>
                                    </h3>
                                    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                                        <div class="h-96 bg-blue-600 flex items-center justify-center">
                                            <div id="map" style="height: 400px; width: 100%;"></div>
                                        </div>
                                        <div class="p-6">
                                            <h4 class="text-xl font-semibold mb-3">Visítanos en nuestro local</h4>
                                            <p class="text-gray-600"><span class="font-medium">Dirección:</span> Av. Principal 1234, Temuco</p>
                                            <p class="text-gray-600"><span class="font-medium">Horario:</span> Lunes a Sábado de 9:00 a 17:00 hrs</p>
                                            <div class="mt-4">
                                                <a href="#" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                                    </svg>
                                                    Cómo llegar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </main>
                    </div>

                    @if (Route::has('login'))
                        <div class="h-14.5 hidden lg:block"></div>
                    @endif

                    <!-- Footer mejorado -->
                    <footer id="footer" class="bg-gradient-to-r from-blue-700 to-blue-900 text-white py-12">
                        <div class="container mx-auto px-4">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                                <div>
                                    <h4 class="text-xl font-bold mb-4">Carwash Temuco</h4>
                                    <p class="text-blue-200">El mejor servicio de lavado de autos en la región, con atención personalizada y productos de primera calidad.</p>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold mb-4">Enlaces</h4>
                                    <ul class="space-y-2">
                                        <li><a href="#" class="text-blue-200 hover:text-white transition">Inicio</a></li>
                                        <li><a href="#servicios" class="text-blue-200 hover:text-white transition">Servicios</a></li>
                                        <li><a href="#ubicacion" class="text-blue-200 hover:text-white transition">Ubicación</a></li>
                                        <li><a href="#footer" class="text-blue-200 hover:text-white transition">Contacto</a></li>
                                    </ul>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold mb-4">Contacto</h4>
                                    <ul class="space-y-2">
                                        <li class="flex items-center text-blue-200"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" /></svg> Av. Principal 1234</li>
                                        <li class="flex items-center text-blue-200"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" /></svg> +56 9 1234 5678</li>
                                        <li class="flex items-center text-blue-200"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg> contacto@carwashtemuco.cl</li>
                                    </ul>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold mb-4">Redes Sociales</h4>
                                    <div class="flex space-x-4">
                                        <a href="#" class="bg-blue-600 hover:bg-blue-500 w-10 h-10 rounded-full flex items-center justify-center transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" /></svg>
                                        </a>
                                        <a href="#" class="bg-blue-600 hover:bg-blue-500 w-10 h-10 rounded-full flex items-center justify-center transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                                        </a>
                                        <a href="#" class="bg-blue-600 hover:bg-blue-500 w-10 h-10 rounded-full flex items-center justify-center transition">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" /></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="border-t border-blue-500 mt-8 pt-8 text-center text-blue-200">
                                <p>&copy; 2025 Carwash Temuco. Todos los derechos reservados.</p>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </body>
    <script>
        let currentIndex = 0;
        const items = document.querySelectorAll('.carousel-item');
        const totalItems = items.length;

        const prevButton = document.getElementById('prev');
        const nextButton = document.getElementById('next');

        // Función para mover el carrusel
        const moveCarousel = (direction) => {
            if (direction === 'next') {
                currentIndex = (currentIndex + 1) % totalItems;
            } else if (direction === 'prev') {
                currentIndex = (currentIndex - 1 + totalItems) % totalItems;
            }
            const newTransformValue = -currentIndex * 100;
            document.querySelector('.carousel-inner').style.transform = `translateX(${newTransformValue}%)`;
        };

        // Eventos para los botones (opcional)
        prevButton.addEventListener('click', () => moveCarousel('prev'));
        nextButton.addEventListener('click', () => moveCarousel('next'));

        // Movimiento automático del carrusel cada 3 segundos
        setInterval(() => {
            moveCarousel('next');
        }, 3000);


        // Función para inicializar el mapa
        function initMap() {
            // Crear un objeto LatLng para la ubicación de tu servicio
            const location = { lat: -38.728415, lng: -72.579291 }; // Cambia las coordenadas con la ubicación de tu servicio

            // Crear el mapa centrado en la ubicación
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15, // Nivel de zoom
                center: location,
            });

            // Crear un marcador en la ubicación de tu servicio
            const marker = new google.maps.Marker({
                position: location,
                map: map,
                title: "Mi Servicio", // Puedes poner el nombre de tu servicio aquí
            });
        }
    </script>
</html>
