@extends('layouts.municipal')

@section('title', 'Regidores y Cabildo')

@section('content')
    <main class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 py-8 lg:grid-cols-3">
        <section class="institutional-card lg:col-span-2">
            <h1 class="mb-4 border-b-2 border-teal-600 pb-2 text-3xl font-bold text-slate-800">Integrantes del H. Ayuntamiento</h1>
            <p class="mb-6 text-sm text-slate-600">
                La integración oficial del Cabildo y la asignación de comisiones se incorporarán una vez validadas por el Ayuntamiento.
            </p>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <article class="flex items-center gap-4 rounded-lg border bg-slate-50 p-4">
                    <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-slate-200 text-2xl" aria-hidden="true">👤</span>
                    <div>
                        <h2 class="font-bold text-slate-800">Sindicatura Municipal</h2>
                        <p class="text-xs font-semibold text-teal-700">Datos de titular y comisión pendientes de validación oficial.</p>
                    </div>
                </article>
                <article class="flex items-center gap-4 rounded-lg border bg-slate-50 p-4">
                    <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-slate-200 text-2xl" aria-hidden="true">👤</span>
                    <div>
                        <h2 class="font-bold text-slate-800">Regidurías</h2>
                        <p class="text-xs font-semibold text-teal-700">Integrantes y comisiones pendientes de validación oficial.</p>
                    </div>
                </article>
            </div>
        </section>

        <aside>
            <section class="sidebar-box">
                <h2 class="mb-2 font-bold text-slate-800">Información del Cabildo</h2>
                <p class="text-sm text-slate-600">Los nombres, comisiones y medios de contacto se publicarán cuando estén confirmados oficialmente.</p>
            </section>
        </aside>
    </main>
@endsection
