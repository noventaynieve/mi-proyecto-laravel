@extends('layouts.municipal')

@section('title', 'Directorio Municipal')

@section('content')
    <main class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 py-8 lg:grid-cols-3">
        <section class="institutional-card lg:col-span-2">
            <h1 class="mb-6 border-b border-gray-200 pb-3 text-xl font-bold text-gray-900">Directorio de Funcionarios y Directores</h1>

            <div class="mb-6">
                <label for="select-dependencia" class="mb-2 block text-xs font-bold uppercase text-gray-700">Filtrar por dependencia</label>
                <select id="select-dependencia" class="w-full rounded-md border border-gray-300 p-2.5 text-sm text-gray-800 focus:ring-2 focus:ring-gobierno-blue">
                    <option value="todas">Todas las dependencias</option>
                    <option value="general">Secretaría General</option>
                    <option value="hacienda">Hacienda Municipal</option>
                    <option value="obras">Obras Públicas</option>
                </select>
            </div>

            <div id="contenedor-directores" class="grid grid-cols-1 gap-4 md:grid-cols-2" aria-live="polite">
                <article class="director-card rounded-lg border border-gray-200 bg-slate-50 p-4" data-dependencia="general">
                    <h2 class="font-bold text-gray-900">Secretaría General</h2>
                    <p class="mb-2 mt-2 text-xs font-bold text-amber-700">Titular pendiente de confirmación</p>
                    <p class="text-xs text-gray-600">Los datos de contacto se publicarán una vez validados oficialmente.</p>
                </article>
                <article class="director-card rounded-lg border border-gray-200 bg-slate-50 p-4" data-dependencia="hacienda">
                    <h2 class="font-bold text-gray-900">Hacienda Municipal</h2>
                    <p class="mb-2 mt-2 text-xs font-bold text-amber-700">Titular pendiente de confirmación</p>
                    <p class="text-xs text-gray-600">Los datos de contacto se publicarán una vez validados oficialmente.</p>
                </article>
                <article class="director-card rounded-lg border border-gray-200 bg-slate-50 p-4" data-dependencia="obras">
                    <h2 class="font-bold text-gray-900">Obras Públicas</h2>
                    <p class="mb-2 mt-2 text-xs font-bold text-amber-700">Titular pendiente de confirmación</p>
                    <p class="text-xs text-gray-600">Los datos de contacto se publicarán una vez validados oficialmente.</p>
                </article>
            </div>
        </section>

        <aside class="space-y-6">
            <section class="institutional-card">
                <h2 class="mb-4 border-b border-gray-200 pb-2 text-base font-bold uppercase tracking-wider text-gray-900">Entradas del sitio</h2>
                <label for="site-entries" class="sr-only">Entradas del sitio</label>
                <select id="site-entries" class="w-full rounded border border-gray-300 p-2 text-sm text-gray-600">
                    <option value="">Elegir el mes</option>
                    <option value="marzo-2026">Marzo 2026</option>
                    <option value="febrero-2026">Febrero 2026</option>
                </select>
            </section>
            <section class="institutional-card">
                <h2 class="mb-3 border-b border-gray-200 pb-2 text-base font-bold text-gray-900">Presidente Municipal</h2>
                <p class="font-bold text-gray-900">Luis Armando Aldana González</p>
                <p class="mt-2 text-sm text-gray-600">Presidente Municipal de Cocula, Jalisco</p>
                <a href="mailto:presidencia@cocula.gob.mx" class="mt-3 inline-block text-sm font-semibold text-gobierno-blue hover:underline">presidencia@cocula.gob.mx</a>
            </section>
        </aside>
    </main>
@endsection
