@extends('layouts.municipal')

@section('title', 'Noticias')

@section('content')
    <main class="mx-auto max-w-7xl space-y-8 px-4 py-8">
        <header class="space-y-2 border-b border-gray-200 pb-4">
            <h1 class="text-3xl font-extrabold text-slate-900">Noticias y avisos</h1>
            <p class="text-sm text-slate-600">Comunicados oficiales del Gobierno Municipal de Cocula.</p>
        </header>

        <form action="{{ route('noticias.index') }}" method="GET" class="grid gap-4 rounded-lg border border-gray-200 bg-white p-4 sm:grid-cols-[1fr_16rem_auto]">
            <div>
                <label for="buscar-noticias" class="mb-1 block text-sm font-semibold text-slate-700">Buscar noticias</label>
                <input id="buscar-noticias" type="search" name="buscar" value="{{ $filters['buscar'] ?? '' }}" maxlength="100" class="w-full rounded border border-gray-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label for="categoria-noticias" class="mb-1 block text-sm font-semibold text-slate-700">Categoría</label>
                <select id="categoria-noticias" name="categoria" class="w-full rounded border border-gray-300 bg-white px-3 py-2 text-sm">
                    <option value="">Todas las categorías</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->slug }}" @selected(($filters['categoria'] ?? '') === $categoria->slug)>{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full rounded bg-[#0b435b] px-5 py-2 text-sm font-semibold text-white hover:bg-[#083346] sm:w-auto">Filtrar</button>
            </div>
        </form>

        <section class="grid gap-6 md:grid-cols-2 lg:grid-cols-3" aria-label="Resultados de noticias">
            @forelse ($noticias as $noticia)
                <article class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    @if ($noticia->imageUrl())
                        <img src="{{ $noticia->imageUrl() }}" alt="{{ $noticia->titulo }}" class="h-52 w-full object-cover">
                    @endif
                    <div class="space-y-3 p-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-teal-800">{{ $noticia->categoria->nombre }} · {{ $noticia->fecha_publicacion->format('d/m/Y') }}</p>
                        <h2 class="text-lg font-bold leading-snug text-slate-900">
                            <a href="{{ route('noticias.show', $noticia) }}" class="hover:underline">{{ $noticia->titulo }}</a>
                        </h2>
                        <p class="text-sm leading-relaxed text-slate-600">{{ $noticia->extracto }}</p>
                        <a href="{{ route('noticias.show', $noticia) }}" class="inline-block text-sm font-semibold text-teal-800 hover:underline">Leer más</a>
                    </div>
                </article>
            @empty
                <p class="rounded-lg border border-gray-200 bg-white p-6 text-sm text-slate-600 md:col-span-2 lg:col-span-3">No se encontraron noticias publicadas.</p>
            @endforelse
        </section>

        {{ $noticias->links() }}
    </main>
@endsection
