@extends('layouts.municipal')

@section('title', 'Gaceta Municipal')

@section('content')
    <main class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 py-8 lg:grid-cols-3">
        <section class="space-y-10 lg:col-span-2">
            <h1 class="border-b pb-4 text-3xl font-bold uppercase tracking-tight text-slate-900">Gaceta</h1>

            @foreach ($publications as $publication)
                <article @class(['space-y-3', 'border-t border-gray-200 pt-6' => ! $loop->first])>
                    @if ($publication['available'])
                        <div class="w-full overflow-hidden rounded-md border border-gray-400 shadow-md" style="height: 650px; background-color: #323639;">
                            <object
                                data="{{ $publication['url'] }}#view=FitH&toolbar=1"
                                type="application/pdf"
                                class="h-full w-full"
                                style="width: 100%; height: 650px;"
                            >
                                <iframe
                                    src="{{ $publication['url'] }}#view=FitH&toolbar=1"
                                    title="{{ $publication['title'] }}"
                                    class="h-full w-full border-0"
                                    style="width: 100%; height: 650px;"
                                ></iframe>
                            </object>
                        </div>
                        <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center sm:justify-between">
                            <a href="{{ $publication['url'] }}" target="_blank" rel="noopener noreferrer" class="text-sm font-medium text-slate-700 underline hover:text-[#0b435b]">
                                {{ $publication['title'] }}
                            </a>
                            <a href="{{ $publication['url'] }}" download class="btn-descarga-pill">
                                Descarga
                            </a>
                        </div>
                    @else
                        <div class="flex aspect-video w-full items-center justify-center rounded-md border border-slate-300 bg-slate-800 px-6 text-center text-sm text-white">
                            El visor estará disponible cuando se agregue el PDF.
                        </div>
                        <div class="flex flex-col gap-3 pt-1 sm:flex-row sm:items-center sm:justify-between">
                            <span class="text-xs font-medium leading-relaxed text-slate-600 sm:text-sm">{{ $publication['title'] }}</span>
                            <span class="btn-descarga-pill cursor-not-allowed opacity-50" aria-disabled="true">Descarga</span>
                        </div>
                        <p class="text-xs text-slate-500">Coloca <code>{{ basename($publication['path']) }}</code> en <code>public/pdf/gaceta</code>.</p>
                    @endif
                </article>
            @endforeach
        </section>

        <aside class="space-y-8">
            <section class="sidebar-box">
                <h2 class="mb-3 text-sm font-bold uppercase tracking-wider text-slate-900">Entradas del sitio</h2>
                <label for="gaceta-entradas" class="sr-only">Elegir el mes de las entradas</label>
                <select id="gaceta-entradas" class="w-full rounded border border-gray-300 bg-white p-2 text-xs text-slate-600">
                    <option value="">Elegir el mes</option>
                    <option value="sep-2026">Septiembre 2026</option>
                    <option value="ago-2026">Agosto 2026</option>
                </select>
            </section>

            <section class="sidebar-box">
                <h2 class="mb-3 text-sm font-bold uppercase tracking-wider text-slate-900">Archivos</h2>
                <label for="gaceta-archivos" class="sr-only">Elegir el mes de los archivos</label>
                <select id="gaceta-archivos" class="w-full rounded border border-gray-300 bg-white p-2 text-xs text-slate-600">
                    <option value="">Elegir el mes</option>
                    <option value="2026-09">Septiembre 2026</option>
                </select>
            </section>

            <section class="sidebar-box space-y-4">
                <h2 class="border-b pb-2 text-sm font-bold uppercase tracking-wider text-slate-900">Notas</h2>
                <p class="border-b pb-3 text-xs leading-relaxed text-slate-600">Cocula reactiva el Sistema de Comando de Incidentes para reforzar las acciones de prevención y combate al dengue</p>
                <p class="text-xs leading-relaxed text-slate-600">Cocula cumple al 100% con la comprobación de recursos del programa Listo Jalisco</p>
            </section>
        </aside>
    </main>
@endsection
