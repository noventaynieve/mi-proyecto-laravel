@extends('layouts.municipal')

@section('title', 'Página Oficial')

@section('content')
    <section class="municipal-hero relative flex min-h-[380px] items-end justify-end overflow-hidden p-8 text-white">
        <div class="rounded-full bg-amber-400 px-6 py-2 text-xl font-extrabold text-slate-950 shadow-lg md:text-2xl">
            Cascada El Salto
        </div>
    </section>

    <main class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 py-8 lg:grid-cols-3">
        <section class="space-y-8 lg:col-span-2">
            <div>
                <h1 class="mb-4 text-2xl font-extrabold text-slate-800">Bienvenido al Gobierno Municipal de Cocula</h1>
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                    <a href="{{ route('tramites') }}" class="rounded-lg border bg-white p-4 text-center shadow transition hover:shadow-md">
                        <span class="mb-2 block text-3xl" aria-hidden="true">💳</span>
                        <span class="text-sm font-semibold text-slate-700">Pago de Predial</span>
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
            </div>

            <section class="institutional-card">
                <h2 class="mb-4 border-b-2 border-teal-600 pb-2 text-xl font-bold text-slate-800">Noticias y Avisos Recientes</h2>
                <p class="text-sm leading-relaxed text-slate-600">Aquí encontrarás comunicados oficiales, avisos a la comunidad e información sobre obras y programas públicos.</p>
            </section>
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
        </aside>
    </main>
@endsection
