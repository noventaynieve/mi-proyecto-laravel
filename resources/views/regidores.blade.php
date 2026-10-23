@extends('layouts.municipal')

@section('title', 'Regidores - Gobierno Municipal de Cocula')

@section('content')
    @php
        $regidores = [
            [
                'name' => 'Martha Liliana Miranda Martinez',
                'photo' => 'images/regidores/martha-miranda.jpg',
                'presides' => 'Salud pública, Desarrollo social y humano, Participación ciudadana.',
                'vocal' => 'Redacción y estilo, comunicación social.',
                'email' => 'regidora.salud@cocula.gob.mx',
                'initials' => 'MM',
            ],
            [
                'name' => 'Lizeth Araceli Solis Lopez',
                'photo' => 'images/regidores/lizeth-solis.jpg',
                'presides' => 'Educación, Cultura y Festividades Públicas.',
                'vocal' => 'Hacienda Municipal, Turismo y Promoción Económica.',
                'email' => 'regidora.educacion@cocula.gob.mx',
                'initials' => 'LS',
            ],
        ];
    @endphp

    <main class="mx-auto grid max-w-7xl grid-cols-1 gap-10 px-4 py-8 lg:grid-cols-3">
        <section class="space-y-12 lg:col-span-2">
            <div class="border-b border-gray-100 pb-4">
                <h1 class="text-3xl font-extrabold uppercase tracking-wide text-slate-900">Regidores</h1>
            </div>

            <div class="space-y-12">
                @foreach ($regidores as $regidor)
                    <article id="regidor-{{ $loop->index }}" class="space-y-6">
                        <div class="grid grid-cols-1 items-start gap-6 sm:grid-cols-12">
                            <div class="sm:col-span-5 md:col-span-4">
                                <div class="flex aspect-[3/4] items-center justify-center overflow-hidden rounded border border-gray-200 bg-gray-100 shadow-sm">
                                    @if (is_file(public_path($regidor['photo'])))
                                        <img
                                            src="{{ asset($regidor['photo']) }}"
                                            alt="{{ $regidor['name'] }}"
                                            class="h-full w-full object-cover"
                                        >
                                    @else
                                        <span class="text-4xl font-bold tracking-widest text-slate-400" role="img" aria-label="Fotografía pendiente de publicación">
                                            {{ $regidor['initials'] }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="space-y-4 text-sm italic text-slate-800 sm:col-span-7 md:col-span-8">
                                <h2 class="text-base font-semibold uppercase tracking-wide text-slate-900 not-italic sm:text-lg">
                                    {{ $regidor['name'] }}
                                </h2>

                                <div class="space-y-1">
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 not-italic">Preside</h3>
                                    <p class="leading-relaxed text-slate-700">{{ $regidor['presides'] }}</p>
                                </div>

                                <div class="space-y-1">
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 not-italic">Vocal</h3>
                                    <p class="leading-relaxed text-slate-700">{{ $regidor['vocal'] }}</p>
                                </div>

                                <div class="space-y-1 pt-1">
                                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 not-italic">Correo electrónico</h3>
                                    <a href="mailto:{{ $regidor['email'] }}" class="text-slate-700 transition-colors hover:text-orange-600">
                                        {{ $regidor['email'] }}
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="relative flex items-center pt-6">
                            <div
                                class="h-4 w-full opacity-30"
                                aria-hidden="true"
                                style="background-image: repeating-linear-gradient(45deg, #d97706 0, #d97706 2px, transparent 0, transparent 8px);"
                            ></div>
                            <a
                                href="#regidor-{{ $loop->index }}"
                                aria-label="Curriculum"
                                class="absolute -top-1 left-8 inline-flex items-center gap-2 rounded-sm bg-[#d97706] px-4 py-2 text-xs font-bold uppercase tracking-wider text-white shadow-md sm:left-12"
                                style="position: absolute; z-index: 10; top: -0.25rem; left: 2rem; display: inline-flex; align-items: center; gap: 0.5rem; border: 0; border-radius: 0.125rem; background-color: #d97706; padding: 0.5rem 1rem; color: #fff; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.05em; text-transform: uppercase; box-shadow: 0 4px 6px rgb(0 0 0 / 0.15);"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Curriculum</span>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <aside class="space-y-8">
            <section class="sidebar-box space-y-3">
                <h2 class="border-b border-gray-200 pb-2 text-xs font-bold uppercase tracking-wider text-slate-900">Entradas del sitio</h2>
                <label for="regidores-entradas" class="sr-only">Elegir el mes de las entradas</label>
                <select id="regidores-entradas" class="w-full rounded border border-gray-300 bg-white p-2 text-xs text-slate-600">
                    <option value="">Elegir el mes</option>
                    <option value="octubre-2026">Octubre 2026</option>
                    <option value="septiembre-2026">Septiembre 2026</option>
                </select>
            </section>

            <section class="sidebar-box space-y-3">
                <h2 class="border-b border-gray-200 pb-2 text-xs font-bold uppercase tracking-wider text-slate-900">Archivos</h2>
                <label for="regidores-archivos" class="sr-only">Elegir el mes de los archivos</label>
                <select id="regidores-archivos" class="w-full rounded border border-gray-300 bg-white p-2 text-xs text-slate-600">
                    <option value="">Elegir el mes</option>
                    <option value="2026-10">Octubre 2026</option>
                    <option value="2026-09">Septiembre 2026</option>
                </select>
            </section>

            <section class="sidebar-box space-y-4">
                <h2 class="border-b border-gray-200 pb-2 text-xs font-bold uppercase tracking-wider text-slate-900">Notas</h2>
                <ul class="space-y-4 text-xs leading-relaxed text-slate-600">
                    <li>
                        <a href="{{ route('noticias.index') }}" class="transition-colors hover:text-slate-900">
                            Cocula reactiva el Sistema de Comando de Incidentes para reforzar las acciones de prevención y combate al dengue
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('gaceta') }}" class="transition-colors hover:text-slate-900">
                            Cocula cumple al 100% con la comprobación de recursos del programa Listo Jalisco
                        </a>
                    </li>
                </ul>
            </section>
        </aside>
    </main>
@endsection
