@extends('layouts.municipal')

@section('title', 'Trámites y Servicios')

@section('content')
    <main class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 py-8 lg:grid-cols-3">
        <section class="institutional-card lg:col-span-2">
            <h1 class="mb-4 border-b border-gray-200 pb-3 text-xl font-bold text-gray-900">Pago de Servicios y Trámites Municipales</h1>
            <p class="mb-6 text-xs leading-relaxed text-gray-600">
                Realiza el pago de tus impuestos y contribuciones municipales de manera digital. Los pagos en línea estarán disponibles cuando se habiliten sus plataformas oficiales.
            </p>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <article class="rounded-lg border border-gray-200 bg-slate-50 p-4">
                    <h2 class="mb-2 text-sm font-bold text-gray-800">Pago de Predial</h2>
                    <p class="mb-4 text-xs text-gray-600">Ingresa tu cuenta catastral para conocer tu saldo e imprimir tu recibo.</p>
                    <button type="button" disabled aria-describedby="services-unavailable" class="cursor-not-allowed rounded bg-amber-400 px-4 py-2 text-xs font-bold text-gray-900 opacity-70">Pagar Predial</button>
                </article>
                <article class="rounded-lg border border-gray-200 bg-slate-50 p-4">
                    <h2 class="mb-2 text-sm font-bold text-gray-800">Licencias Municipales</h2>
                    <p class="mb-4 text-xs text-gray-600">Refrendo de giros comerciales y consulta de requisitos.</p>
                    <button type="button" disabled aria-describedby="services-unavailable" class="cursor-not-allowed rounded bg-amber-400 px-4 py-2 text-xs font-bold text-gray-900 opacity-70">Consultar Trámite</button>
                </article>
                <article class="rounded-lg border border-gray-200 bg-slate-50 p-4">
                    <h2 class="mb-2 text-sm font-bold text-gray-800">Agua Potable y Servicios</h2>
                    <p class="mb-4 text-xs text-gray-600">Consulta información de pagos y reportes de servicio de agua.</p>
                    <button type="button" disabled aria-describedby="services-unavailable" class="cursor-not-allowed rounded bg-amber-400 px-4 py-2 text-xs font-bold text-gray-900 opacity-70">Ir a Servicios</button>
                </article>
            </div>
            <p id="services-unavailable" class="mt-4 text-xs text-gray-500">Los enlaces de pago y consulta se activarán cuando los servicios correspondientes estén disponibles.</p>
        </section>

        <aside>
            <section class="institutional-card">
                <h2 class="mb-4 border-b border-gray-200 pb-2 text-base font-bold uppercase tracking-wider text-gray-900">Entradas del sitio</h2>
                <label for="site-entries" class="sr-only">Entradas del sitio</label>
                <select id="site-entries" class="w-full rounded border border-gray-300 p-2 text-sm text-gray-600 focus:border-gobierno-blue focus:outline-none">
                    <option value="">Elegir el mes</option>
                    <option value="marzo-2026">Marzo 2026</option>
                    <option value="febrero-2026">Febrero 2026</option>
                </select>
            </section>
        </aside>
    </main>
@endsection
