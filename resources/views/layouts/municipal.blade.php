<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Gobierno de Cocula, Jalisco</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <div class="bg-gobierno-navy px-4 py-2 text-xs text-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-3">
            <span>Portal Oficial del H. Ayuntamiento</span>
            <div class="flex items-center gap-3" role="group" aria-label="Opciones de accesibilidad">
                <button id="btn-decrease-font" type="button" class="hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-white" aria-label="Reducir tamaño del texto">A-</button>
                <button id="btn-increase-font" type="button" class="hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-white" aria-label="Aumentar tamaño del texto">A+</button>
                <button id="btn-contrast" type="button" class="hover:underline focus-visible:outline focus-visible:outline-2 focus-visible:outline-white" aria-pressed="false">Alto contraste</button>
            </div>
        </div>
    </div>

    <header class="border-b border-gray-200 bg-white px-4 py-4 sm:px-6">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-4 md:flex-row md:items-center">
            <a href="{{ url('/') }}" class="flex items-center gap-4">
                <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded bg-gray-200 text-xs font-semibold text-gray-600" aria-label="Gobierno de Cocula">
                    Cocula
                </span>
                <span>
                    <span class="block text-xs font-medium uppercase tracking-wider text-gray-500">Bienvenidos a la página oficial de</span>
                    <span class="block text-2xl font-extrabold leading-tight text-amber-700 md:text-3xl">Gobierno de Cocula, Jalisco</span>
                    <span class="block text-xs font-medium text-gray-500">2024 - 2027</span>
                </span>
            </a>

            <div class="flex w-full flex-col gap-3 md:w-auto md:flex-row md:items-center">
                <form action="{{ route('buscar') }}" method="GET" role="search" class="flex w-full md:w-80">
                    <label for="site-search" class="sr-only">Buscar secciones del portal</label>
                    <input id="site-search" type="search" name="q" maxlength="100" required placeholder="Buscar trámites o información" class="min-w-0 flex-1 rounded-l-lg border border-gray-300 px-3 py-2 text-sm focus:z-10 focus:border-teal-700 focus:outline-none focus:ring-2 focus:ring-teal-700">
                    <button type="submit" class="rounded-r-lg bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-700">Buscar</button>
                </form>
                <div class="flex items-center gap-3 text-sm text-gray-600">
                    <span class="hidden sm:inline">Síguenos:</span>
                    <a href="#" aria-label="Facebook" class="flex h-7 w-7 items-center justify-center rounded-full bg-blue-600 font-bold text-white hover:opacity-90">f</a>
                    <a href="#" aria-label="YouTube" class="flex h-7 items-center justify-center rounded bg-red-600 px-2 font-bold text-white hover:opacity-90">YouTube</a>
                </div>
            </div>
        </div>

        <div class="mx-auto mt-3 max-w-7xl border-t border-gray-100 pt-2">
            <p class="text-base font-bold text-gray-800">Gobierno de Cocula Jalisco</p>
            <p class="text-xs text-gray-500">Administración 2024-2027</p>
        </div>
    </header>

    <nav aria-label="Navegación principal" class="relative z-50 bg-gobierno-navy text-white shadow-md">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between px-2">
            <ul class="flex flex-wrap items-center gap-1 py-1 text-xs font-bold uppercase tracking-wider">
                <li>
                    <a href="{{ url('/') }}" @class([
                        'block px-3 py-3 transition hover:bg-gobierno-hover',
                        'bg-gobierno-dark' => request()->routeIs('home', 'menu'),
                    ])>Inicio</a>
                </li>
                <li class="relative" data-dropdown>
                    <div class="flex items-center">
                        <a href="{{ route('presidencia') }}" @class([
                            'block px-3 py-3 transition hover:bg-gobierno-hover',
                            'bg-gobierno-dark' => request()->routeIs('presidencia'),
                        ])>PRESIDENCIA</a>
                        <button id="dropdown-presidencia-btn" type="button" aria-label="Abrir opciones de Presidencia" aria-expanded="false" aria-controls="dropdown-presidencia-menu" class="px-2 py-3 transition hover:bg-gobierno-hover focus:outline-none focus-visible:ring-2 focus-visible:ring-white" data-dropdown-toggle>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 9-7 7-7-7"></path></svg>
                        </button>
                    </div>
                    <div id="dropdown-presidencia-menu" class="dropdown-menu absolute left-0 top-full w-64 border border-gray-200 bg-white py-2 text-gray-800 shadow-xl" data-dropdown-menu>
                        <a href="{{ route('presidencia') }}" class="block px-4 py-2.5 text-sm font-semibold hover:bg-cyan-50 hover:text-cyan-900">Directores</a>
                        <a href="{{ route('regidores') }}" class="block px-4 py-2.5 text-sm font-semibold hover:bg-cyan-50 hover:text-cyan-900">Regidores y Cabildo</a>
                        <a href="{{ route('presidencia') }}" class="block px-4 py-2.5 text-sm font-semibold hover:bg-cyan-50 hover:text-cyan-900">Organigrama</a>
                        <a href="{{ route('presidencia') }}" class="block px-4 py-2.5 text-sm font-semibold hover:bg-cyan-50 hover:text-cyan-900">Sesiones de Ayuntamiento</a>
                        <a href="{{ route('gaceta') }}" class="block px-4 py-2.5 text-sm font-semibold hover:bg-cyan-50 hover:text-cyan-900">Gaceta Municipal y Edictos</a>
                        <a href="{{ route('transparencia') }}" class="block px-4 py-2.5 text-sm font-semibold hover:bg-cyan-50 hover:text-cyan-900">SEVAC</a>
                    </div>
                </li>
                <li><a href="{{ route('atencion-ciudadana') }}" class="block px-3 py-3 transition hover:bg-gobierno-hover">Atención Ciudadana</a></li>
                <li>
                    <a href="{{ route('tramites') }}" @class([
                        'flex flex-col px-3 py-2 text-center leading-tight transition hover:bg-gobierno-hover',
                        'bg-gobierno-dark' => request()->routeIs('tramites'),
                    ])><span>PAGO</span><span>DE SERV</span></a>
                </li>
                <li><a href="#" class="block px-3 py-3 transition hover:bg-gobierno-hover">Reglamentos</a></li>
                <li><a href="#" class="block px-3 py-3 transition hover:bg-gobierno-hover">Conv</a></li>
                <li><a href="#" class="block px-3 py-3 transition hover:bg-gobierno-hover">DIF</a></li>
                <li>
                    <a href="{{ route('transparencia') }}" @class([
                        'block px-3 py-3 transition hover:bg-gobierno-hover',
                        'bg-gobierno-dark' => request()->routeIs('transparencia'),
                    ])>Transp</a>
                </li>
                <li><a href="#" class="block px-3 py-3 transition hover:bg-gobierno-hover">Info</a></li>
                <li><a href="#" class="block px-3 py-3 transition hover:bg-gobierno-hover">Acces</a></li>
                <li><a href="#" class="block px-3 py-3 transition hover:bg-gobierno-hover">Otros</a></li>
            </ul>
        </div>
    </nav>

    @yield('content')

    <footer class="mt-12 border-t-4 border-gobierno-gold bg-gobierno-navy pb-6 pt-10 text-white">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-8 border-b border-white/20 px-4 pb-8 text-sm md:grid-cols-3">
            <section>
                <h2 class="mb-3 border-b border-white/20 pb-2 text-base font-bold">H. Ayuntamiento de Cocula</h2>
                <p class="mb-3 text-xs leading-relaxed text-gray-200">Presidencia Municipal: Hidalgo #1, Centro, Cocula, Jalisco, México.</p>
                <p class="text-xs text-gray-200">Teléfono: (375) 752 0000</p>
                <p class="text-xs text-gray-200">Correo: contacto@cocula.gob.mx</p>
            </section>

            <section>
                <h2 class="mb-3 border-b border-white/20 pb-2 text-base font-bold">Enlaces Institucionales</h2>
                <ul class="space-y-2 text-xs text-gray-200">
                    <li><a href="{{ route('transparencia') }}" class="hover:underline">Transparencia</a></li>
                    <li><a href="{{ route('solicitud-transparencia') }}" class="hover:underline">Solicitud de información (demostración)</a></li>
                    <li><a href="{{ route('tramites') }}" class="hover:underline">Trámites y Servicios</a></li>
                    <li><a href="{{ route('solicitud-licencia') }}" class="hover:underline">Solicitud de licencia (demostración)</a></li>
                    <li><a href="{{ route('gaceta') }}" class="hover:underline">Gaceta Municipal</a></li>
                    <li><a href="{{ route('atencion-ciudadana') }}" class="hover:underline">Atención Ciudadana</a></li>
                    <li><a href="{{ route('contacto') }}" class="hover:underline">Contacto (demostración)</a></li>
                    <li><span>Protección de Datos</span></li>
                    <li><span>Bolsa de Trabajo</span></li>
                    <li><span>Normatividad Municipal</span></li>
                </ul>
            </section>

            <section>
                <h2 class="mb-3 border-b border-white/20 pb-2 text-base font-bold">Horarios de Atención</h2>
                <p class="mb-1 text-xs text-gray-200">Lunes a Viernes:</p>
                <p class="mb-3 text-xs font-bold text-amber-300">9:00 AM - 3:00 PM</p>
                <p class="mb-1 text-xs text-gray-200">Sábado:</p>
                <p class="text-xs font-bold text-amber-300">9:00 AM - 1:00 PM</p>
            </section>
        </div>

        <div class="mx-auto max-w-7xl px-4 pt-6 text-center text-xs text-gray-200">
            <p>&copy; 2026 Gobierno de Cocula, Jalisco. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
