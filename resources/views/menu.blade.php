@extends('layouts.municipal')

@section('title', 'Inicio - Gobierno de Cocula, Jalisco')

@section('content')
    <section class="municipal-hero relative flex min-h-[380px] items-end justify-end overflow-hidden p-8 text-white">
        <div class="rounded-full bg-amber-400 px-6 py-2 text-xl font-extrabold text-slate-950 shadow-lg md:text-2xl">
            Cascada El Salto
        </div>
    </section>

    <main class="mx-auto max-w-7xl space-y-10 px-4 py-8">
        <section class="space-y-4">
            <h1 class="text-2xl font-extrabold text-slate-800">
                Bienvenido al Gobierno Municipal de Cocula
            </h1>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                <a href="{{ route('tramites') }}" class="rounded-lg border bg-white p-4 text-center shadow transition hover:shadow-md">
                    <span class="mb-2 block text-3xl" aria-hidden="true">💳</span>
                    <span class="text-sm font-semibold text-slate-700">Pago de Predial y Agua </span>
                </a>
                <a href="{{ route('tramites') }}" class="rounded-lg border bg-white p-4 text-center shadow transition hover:shadow-md">
                    <span class="mb-2 block text-3xl" aria-hidden="true">📜</span>
                    <span class="text-sm font-semibold text-slate-700">Licencias</span>
                </a>
                <a href="{{ route('atencion-ciudadana') }}" class="rounded-lg border bg-white p-4 text-center shadow transition hover:shadow-md">
                    <span class="mb-2 block text-3xl" aria-hidden="true">🛠️</span>
                    <span class="text-sm font-semibold text-slate-700">Atención Ciudadana</span>
                </a>
                <a href="{{ route('gaceta') }}" class="rounded-lg border bg-white p-4 text-center shadow transition hover:shadow-md">
                    <span class="mb-2 block text-3xl" aria-hidden="true">📄</span>
                    <span class="text-sm font-semibold text-slate-700">Gaceta</span>
                </a>
            </div>
        </section>

        <section class="space-y-2 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="inline-block border-b-2 border-[#0b435b] pb-2 text-2xl font-bold text-[#0b435b]">
                Noticias y Avisos Recientes
            </h2>
            <p class="text-xs text-slate-600 sm:text-sm">
                Aquí encontrarás comunicados oficiales, avisos a la comunidad e información sobre obras y programas públicos.
            </p>
            <a href="{{ route('noticias.index') }}" class="text-sm font-semibold text-teal-700 hover:underline">Ver todas las noticias</a>
        </section>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <section class="space-y-8 lg:col-span-2" aria-label="Noticias principales">
                @forelse ($noticias as $noticia)
                    <article class="space-y-4 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                        @if ($noticia->imageUrl())
                            <div class="w-full overflow-hidden">
                                <img src="{{ $noticia->imageUrl() }}" alt="{{ $noticia->titulo }}" class="h-auto w-full object-cover">
                            </div>
                        @endif

                        <div class="space-y-3 p-6">
                            <h2 class="text-xl font-bold leading-snug text-slate-900 sm:text-2xl">
                                {{ $noticia->titulo }}
                            </h2>
                            <div class="text-xs font-medium tracking-wide text-slate-400">
                                <time datetime="{{ $noticia->fecha_publicacion->toDateString() }}">{{ $noticia->fecha_publicacion->format('M d, Y') }}</time>
                                <span class="mx-1">/</span>
                                <span>{{ $noticia->categoria->nombre }}</span>
                            </div>
                            <p class="text-justify text-xs leading-relaxed text-slate-600 sm:text-sm">{{ $noticia->extracto }}</p>
                            <div class="pt-2">
                                <a href="{{ route('noticias.show', $noticia) }}" class="btn-read-more">Leer más</a>
                            </div>
                        </div>
                    </article>
                @empty
                    <p class="rounded-lg border border-gray-200 bg-white p-6 text-sm text-slate-600">Aún no hay noticias publicadas.</p>
                @endforelse
            </section>

            <aside class="space-y-6">
                <section class="sidebar-box">
                    <h2 class="mb-2 font-bold text-slate-800">Avisos Importantes</h2>
                    <p class="text-sm text-slate-600">Consulta en las oficinas del Ayuntamiento la información vigente sobre el pago del predial y otros servicios municipales.</p>
                </section>

                <section class="sidebar-box">
                    <h2 class="mb-2 font-bold text-slate-800">Consulta rápida</h2>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('transparencia') }}" class="font-semibold text-teal-700 hover:underline">Transparencia y SEVAC</a></li>
                        <li><a href="{{ route('regidores') }}" class="font-semibold text-teal-700 hover:underline">Regidores y Cabildo</a></li>
                        <li><a href="{{ route('atencion-ciudadana') }}" class="font-semibold text-teal-700 hover:underline">Atención Ciudadana</a></li>
                    </ul>
                </section>

                <section class="sidebar-box space-y-3">
                    <h2 class="border-b pb-2 text-sm font-bold uppercase tracking-wider text-slate-900">Entradas del sitio</h2>
                    <label for="site-entries-month" class="sr-only">Elegir el mes de las entradas</label>
                    <select id="site-entries-month" class="w-full rounded border border-gray-300 bg-white p-2 text-xs text-slate-600">
                        <option value="">Elegir el mes</option>
                        <option value="oct-2026">Octubre 2026</option>
                        <option value="sep-2026">Septiembre 2026</option>
                    </select>
                </section>

                <section class="sidebar-box space-y-3">
                    <h2 class="border-b pb-2 text-sm font-bold uppercase tracking-wider text-slate-900">Archivos</h2>
                    <label for="site-archives-month" class="sr-only">Elegir el mes de los archivos</label>
                    <select id="site-archives-month" class="w-full rounded border border-gray-300 bg-white p-2 text-xs text-slate-600">
                        <option value="">Elegir el mes</option>
                        <option value="2026-10">Octubre 2026</option>
                    </select>
                </section>
            </aside>
        </div>
    </main>
@endsection
