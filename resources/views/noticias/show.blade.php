@extends('layouts.municipal')

@section('title', $noticia->titulo)

@section('content')
    <main class="mx-auto max-w-5xl space-y-6 px-4 py-8">
        <article class="space-y-6 rounded-lg border border-gray-200 bg-white p-6 shadow-sm sm:p-10">
            <header class="space-y-2 border-b pb-4">
                <h1 class="text-2xl font-bold leading-tight text-slate-900 sm:text-3xl">{{ $noticia->titulo }}</h1>
                <div class="text-xs font-medium text-slate-400">
                    <time datetime="{{ $noticia->fecha_publicacion->toDateString() }}">{{ $noticia->fecha_publicacion->format('M d, Y') }}</time>
                    <span class="mx-1">/</span>
                    <span>{{ $noticia->categoria->nombre }}</span>
                    @if ($noticia->autor)
                        <span class="mx-1">/</span>
                        <span>{{ $noticia->autor->name }}</span>
                    @endif
                </div>
            </header>

            @if ($noticia->imageUrl())
                <div class="w-full overflow-hidden rounded-md">
                    <img src="{{ $noticia->imageUrl() }}" alt="{{ $noticia->titulo }}" class="h-auto w-full object-cover">
                </div>
            @endif

            <div class="whitespace-pre-line text-justify text-xs leading-relaxed text-slate-700 sm:text-sm">{{ $noticia->contenido }}</div>

            <footer class="border-t pt-6">
                <a href="{{ route('noticias.index') }}" class="flex items-center gap-1 text-xs font-semibold text-[#0b435b] hover:underline">
                    &larr; Volver a noticias
                </a>
            </footer>
        </article>
    </main>
@endsection
