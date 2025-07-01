<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Carwash Temuco</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApEx2GTv--JVnqQH14VD6UXWfa94Spd7k&callback=initMap" async defer></script>


        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <style>
              
            </style>
        @endif

        <style>
            /* Estilos personalizados */
            .hero-section {
                position: relative;
                overflow: hidden;
            }
            
            .hero-section::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('https://images.unsplash.com/photo-1489824904134-891ab64532f1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') no-repeat center center;
                background-size: cover;
                opacity: 0.1;
            }
            
            .shadow-hover {
                box-shadow: 0 5px 15px rgba(0, 123, 255, 0.08);
                transition: all 0.3s ease;
                border-radius: 10px;
                overflow: hidden;
            }
            
            .shadow-hover:hover {
                box-shadow: 0 10px 25px rgba(0, 123, 255, 0.15);
                transform: translateY(-5px);
            }
            
            .card-img-container:hover img {
                transform: scale(1.05);
            }
            
            .date-badge {
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }
            
            .empty-state {
                background-color: #f8fafc;
                border-radius: 10px;
            }
            
            .service-tags .badge {
                transition: all 0.2s ease;
            }
            
            .service-tags .badge:hover {
                transform: translateY(-2px);
            }
        </style>
    </head>
    <body class="bg-blue-50 text-gray-800">
        <header x-data="{ open: false }" class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
                <div class="flex justify-between items-center h-16">
                    <!-- Botones de logo y muro -->
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
                        <!-- Contenido del muro adaptado -->
                        <div class="w-full">
                            <!-- Hero Section adaptada -->
                            <div class="hero-section w-full" style="background: linear-gradient(135deg, #007BFF 0%, #0056b3 100%);">
                                <div class="px-4 py-12 sm:px-6 lg:px-8">
                                    <div class="text-center text-white">
                                        <h1 class="text-4xl font-extrabold tracking-tight sm:text-5xl lg:text-6xl mb-4">Muro de CarwashTemuco</h1>
                                        <p class="text-xl max-w-3xl mx-auto mb-6">Descubre nuestros últimos trabajos y ofertas especiales</p>
                                        <div class="inline-flex px-4 py-2 rounded-full" style="background-color: rgba(255,255,255,0.2);">
                                            <i class="fas fa-sparkles mr-2 mt-1"></i>Profesionales en cuidado automotriz
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Content Section adaptada -->
                            <div class="px-4 py-8 sm:px-6 lg:px-8">
                                <!-- Filter Bar -->
                                <div class="mb-8">
                                    <div class="p-4 rounded-lg shadow-sm" style="background-color: #f8f9fa; border-left: 4px solid #007BFF;">
                                        <div class="flex items-center justify-between">
                                            <h5 class="text-lg font-bold m-0" style="color: #007BFF;">
                                                <i class="fas fa-filter mr-2"></i>Nuestros Trabajos
                                            </h5>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium" style="background-color: #007BFF; color: white;">
                                                {{ count($activities) }} {{ count($activities) === 1 ? 'publicación' : 'publicaciones' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Activities Grid adaptado -->
                                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                                    @forelse ($activities as $activity)
                                    <div class="group relative">
                                        <div class="h-full border-0 rounded-lg overflow-hidden shadow-md group-hover:shadow-lg transition-all duration-300">
                                            <!-- Image with overlay -->
                                            <div class="relative overflow-hidden">
                                                @if($activity->image_path)
                                                <img src="{{ asset('images/' . $activity->image_path) }}" class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-105" alt="{{ $activity->title }}">
                                                @else
                                                <div class="w-full h-56 flex items-center justify-center" style="background: linear-gradient(45deg, #f8f9fa 0%, #e9ecef 100%);">
                                                    <i class="fas fa-car text-gray-400 text-5xl opacity-50"></i>
                                                </div>
                                                @endif
                                                <div class="absolute top-3 right-3">
                                                    <div class="text-center p-2 rounded" style="background-color: rgba(0, 123, 255, 0.9); color: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                                        <div class="font-bold text-lg">{{ \Carbon\Carbon::parse($activity->scheduled_at)->format('d') }}</div>
                                                        <div class="text-xs uppercase">{{ \Carbon\Carbon::parse($activity->scheduled_at)->format('M') }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Card Body -->
                                            <div class="p-6">
                                                <h5 class="text-xl font-bold mb-3" style="color: #0056b3;">{{ $activity->title }}</h5>
                                                <p class="text-gray-600 mb-4">{{ $activity->description }}</p>
                                                
                                                <!-- Service Tags -->
                                                <div class="flex flex-wrap mb-3">
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mr-2 mb-2" style="background-color: #e3f2fd; color: #007BFF;">
                                                        <i class="fas fa-spa mr-1"></i>Lavado premium
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <!-- Card Footer -->
                                            <div class="px-6 pb-4">
                                                <div class="flex justify-between items-center">
                                                    <a href="#" class="inline-flex items-center px-3 py-1 border border-blue-500 rounded-md text-sm font-medium" style="border-color: #007BFF; color: #007BFF;">
                                                        <i class="fas fa-info-circle mr-1"></i> Detalles
                                                    </a>
                                                    <div class="flex space-x-3">
                                                        <a href="#" class="text-gray-400 hover:text-green-500"><i class="fab fa-whatsapp text-xl" style="color: #25D366;"></i></a>
                                                        <a href="#" class="text-gray-400 hover:text-blue-500"><i class="fas fa-envelope text-xl" style="color: #007BFF;"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-span-full">
                                        <div class="text-center py-12 px-4 rounded-lg" style="background-color: #f8fafc;">
                                            <div class="mb-6" style="color: #007BFF;">
                                                <i class="fas fa-car-wash text-5xl"></i>
                                            </div>
                                            <h4 class="text-2xl font-bold mb-3" style="color: #007BFF;">Aún no hay publicaciones</h4>
                                            <p class="text-gray-600 mb-6">Pronto compartiremos nuestros trabajos y ofertas especiales</p>
                                            <button class="px-6 py-2 rounded-md text-white font-medium" style="background-color: #007BFF;">
                                                <i class="fas fa-bell mr-2"></i> Notificarme
                                            </button>
                                        </div>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
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
                                        <li><a href="{{ url('/#servicios') }}" class="text-blue-200 hover:text-white transition">Servicios</a></li>
                                        <li><a href="{{ url('/#ubicacion') }}" class="text-blue-200 hover:text-white transition">Ubicación</a></li>
                                        <li><a href="{{ url('/#footer') }}" class="text-blue-200 hover:text-white transition">Contacto</a></li>
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
    
</html>
    