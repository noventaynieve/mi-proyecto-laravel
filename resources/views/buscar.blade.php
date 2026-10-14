@extends('layouts.municipal')

@section('title', 'Buscar')

@section('content')
    <main class="mx-auto max-w-7xl px-4 py-8">
        <section class="institutional-card">
            <h1 class="mb-4 border-b-2 border-teal-600 pb-2 text-3xl font-bold text-slate-800">Buscar en el portal</h1>

            @if ($query === '')
                <p class="text-sm text-slate-600">Escribe un término para buscar en las secciones municipales.</p>
            @elseif ($results->isEmpty())
                <p class="text-sm text-slate-600">No se encontraron secciones para “{{ $query }}”. Prueba con otro término.</p>
            @else
                <p class="mb-4 text-sm text-slate-600">Resultados para “{{ $query }}”:</p>
                <ul class="divide-y divide-slate-200">
                    @foreach ($results as $result)
                        <li class="py-4">
                            <a href="{{ $result['url'] }}" class="font-semibold text-teal-700 hover:underline">{{ $result['title'] }}</a>
                            <p class="mt-1 text-sm text-slate-600">{{ $result['description'] }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </main>
@endsection
