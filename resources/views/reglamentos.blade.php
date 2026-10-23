@extends('layouts.municipal')

@section('title', 'Reglamentos Municipales')

@section('content')
    <main class="mx-auto max-w-7xl space-y-8 px-4 py-8">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <section class="space-y-6 lg:col-span-2">
                <header class="space-y-3 rounded-lg border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                    <h1 class="text-2xl font-extrabold uppercase tracking-tight text-slate-900 sm:text-3xl">Reglamentos Municipales</h1>
                    <p class="text-sm leading-relaxed text-slate-600">
                        Consulta el marco normativo y reglamentario vigente del Gobierno Municipal de Cocula, Jalisco. Puedes consultar el documento en el visor integrado o descargarlo para revisarlo posteriormente.
                    </p>
                </header>

                <article class="space-y-4 rounded-lg border border-gray-200 bg-white p-6 shadow-sm transition-shadow duration-200 hover:shadow-md">
                    <div class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 pb-3">
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold uppercase text-slate-700">{{ $regulation['category'] }}</span>
                    </div>

                    <h2 class="text-lg font-bold leading-snug text-slate-900">{{ $regulation['title'] }}</h2>
                    <p class="text-sm leading-relaxed text-slate-600">{{ $regulation['description'] }}</p>

                    @if ($regulation['available'])
                        <div class="w-full overflow-hidden rounded-md border border-gray-400 shadow-md" style="height: 650px; background-color: #323639;">
                            <object
                                data="{{ $regulation['url'] }}#view=FitH&toolbar=1"
                                type="application/pdf"
                                class="h-full w-full"
                                style="width: 100%; height: 650px;"
                            >
                                <iframe
                                    src="{{ $regulation['url'] }}#view=FitH&toolbar=1"
                                    title="{{ $regulation['title'] }}"
                                    class="h-full w-full border-0"
                                    style="width: 100%; height: 650px;"
                                ></iframe>
                            </object>
                        </div>
                        <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center sm:justify-between">
                            <a href="{{ $regulation['url'] }}" target="_blank" rel="noopener noreferrer" class="text-sm font-medium text-slate-700 underline hover:text-[#0b435b]">
                                {{ $regulation['title'] }}
                            </a>
                            <a href="{{ $regulation['url'] }}" download class="btn-descarga-pill">
                                Descarga
                            </a>
                        </div>
                    @else
                        <p class="rounded border border-amber-200 bg-amber-50 p-3 text-sm text-amber-900">
                            El documento estará disponible cuando se agregue
                            <code>{{ basename($regulation['path']) }}</code> a <code>public/pdf/reglamentos</code>.
                        </p>
                    @endif
                </article>
            </section>

            <aside class="space-y-6">
                <section class="space-y-4 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="border-b pb-2 text-sm font-bold uppercase tracking-wider text-slate-900">Categorías de reglamentos</h2>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li class="flex items-center justify-between gap-3 py-1">
                            <span>{{ $regulation['category'] }}</span>
                            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs text-slate-700">1</span>
                        </li>
                    </ul>
                </section>

                <section class="space-y-3 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="border-b pb-2 text-sm font-bold uppercase tracking-wider text-slate-900">Entradas del sitio</h2>
                    <label for="reglamentos-entradas" class="sr-only">Elegir el año de las entradas</label>
                    <select id="reglamentos-entradas" class="w-full rounded border border-gray-300 bg-white p-2 text-sm text-slate-600">
                        <option value="">Elegir el año</option>
                        <option value="2026">2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                    </select>
                </section>
            </aside>
        </div>

    </main>
@endsection
