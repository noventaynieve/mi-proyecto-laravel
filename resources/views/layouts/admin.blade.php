<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel administrativo') | Gobierno de Cocula</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ asset('img/logo-cocula.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 font-sans text-slate-800 antialiased">
    <div class="min-h-screen lg:flex">
        <aside class="flex w-full flex-col bg-slate-900 text-white lg:min-h-screen lg:w-72 lg:shrink-0">
            <div class="border-b border-slate-700 px-6 py-5">
                <x-municipal-brand
                    :href="route('admin.dashboard')"
                    logo-class="h-12 w-12 shrink-0 rounded bg-white p-1 object-contain"
                    class="text-white"
                >
                    <span>
                        <span class="block text-lg font-extrabold tracking-wide">COCULA, JALISCO</span>
                        <span class="mt-1 block text-xs text-slate-300">Panel Administrativo 2024–2027</span>
                    </span>
                </x-municipal-brand>
            </div>

            <nav aria-label="Navegación administrativa" class="flex flex-1 flex-wrap gap-2 p-4 lg:flex-col">
                <a href="{{ route('admin.dashboard') }}" @class([
                    'rounded-lg px-4 py-3 text-sm font-semibold transition hover:bg-slate-800',
                    'bg-slate-800 text-white' => request()->routeIs('admin.dashboard'),
                    'text-slate-300' => ! request()->routeIs('admin.dashboard'),
                ])>Dashboard</a>

                <a href="{{ route('admin.formularios.index') }}" @class([
                    'rounded-lg px-4 py-3 text-sm font-semibold transition hover:bg-slate-800',
                    'bg-slate-800 text-white' => request()->routeIs('admin.formularios.*'),
                    'text-slate-300' => ! request()->routeIs('admin.formularios.*'),
                ])>Registro de formularios</a>

                @can('manage-news')
                    <a href="{{ route('admin.noticias.index') }}" @class([
                        'rounded-lg px-4 py-3 text-sm font-semibold transition hover:bg-slate-800',
                        'bg-slate-800 text-white' => request()->routeIs('admin.noticias.*'),
                        'text-slate-300' => ! request()->routeIs('admin.noticias.*'),
                    ])>Noticias y avisos</a>
                    <a href="{{ route('admin.categorias.index') }}" @class([
                        'rounded-lg px-4 py-3 text-sm font-semibold transition hover:bg-slate-800',
                        'bg-slate-800 text-white' => request()->routeIs('admin.categorias.*'),
                        'text-slate-300' => ! request()->routeIs('admin.categorias.*'),
                    ])>Categorías</a>
                @endcan
            </nav>

            <div class="border-t border-slate-700 p-4">
                <p class="truncate px-2 text-sm font-semibold">{{ auth()->user()->name }}</p>
                <p class="px-2 pt-1 text-xs uppercase tracking-wide text-slate-400">{{ auth()->user()->roleLabel() }}</p>
                <div class="mt-4 flex gap-2">
                    <a href="{{ route('home') }}" class="flex-1 rounded-lg border border-slate-600 px-3 py-2 text-center text-xs font-semibold text-slate-200 hover:bg-slate-800">Ver portal</a>
                    <form action="{{ route('logout') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full rounded-lg bg-red-700 px-3 py-2 text-xs font-semibold text-white hover:bg-red-800">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </aside>

        <main class="min-w-0 flex-1 px-4 py-6 sm:px-6 lg:px-10 lg:py-8">
            @if (session('status'))
                <p role="status" class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-sm font-medium text-green-900">{{ session('status') }}</p>
            @endif

            @if ($errors->any())
                <div role="alert" class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-900">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @yield('content')
        </main>
    </div>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
</body>
</html>
