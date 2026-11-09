@extends('layouts.municipal')

@section('title', 'Accesibilidad')

@section('content')
    <main class="mx-auto max-w-7xl space-y-8 px-4 py-8">
        <header class="space-y-3 rounded-lg border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-sm font-bold uppercase tracking-wider text-amber-700">Gobierno de Cocula Jalisco · Administración 2024 - 2027</p>
            <h1 class="text-2xl font-extrabold uppercase tracking-tight text-slate-900 sm:text-3xl">Accesibilidad</h1>
        </header>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <section class="space-y-8 lg:col-span-2">
                <section class="space-y-5 rounded-lg border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                    <h2 class="text-xl font-bold text-slate-900">Programas y Gestiones de Accesibilidad</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[32rem] border-collapse text-left text-sm">
                            <caption class="sr-only">Programas y gestiones de accesibilidad del Gobierno de Cocula</caption>
                            <thead>
                                <tr class="border-b border-gray-200 text-xs uppercase tracking-wider text-slate-600">
                                    <th scope="col" class="px-4 py-3">Programa / Gestión</th>
                                    <th scope="col" class="px-4 py-3">Enlace de Acceso</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-slate-700">
                                @foreach ([
                                    'Programa de accesibilidad',
                                    'Gestiones ante el CRIT de Occidente',
                                    'Oro para Cocula en los CONADE',
                                    'Cocula reconoce participación en los CONADE 2021',
                                ] as $program)
                                    <tr>
                                        <th scope="row" class="px-4 py-4 font-semibold">{{ $program }}</th>
                                        <td class="px-4 py-4 text-slate-500">Enlace pendiente de publicación</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="space-y-4 rounded-lg border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                    <h2 class="text-xl font-bold text-slate-900">Información sobre Accesibilidad Web</h2>
                    <div class="space-y-4 text-sm leading-relaxed text-slate-700">
                        <p>Existen funciones diseñadas para usuarios con deficiencias auditivas o visuales.</p>
                        <p>Estas funciones pueden mejorar radicalmente la vida de aquellas personas que padecen de alguna discapacidad.</p>
                        <p>Mediante la accesibilidad web, una persona con discapacidad puede acceder a páginas web, compartir información en redes sociales y hasta comunicarse con otras personas en el mundo.</p>
                        <p>¿Fantástico, verdad?</p>
                    </div>
                </section>
            </section>

            <aside>
                <section class="space-y-4 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                    <h2 class="border-b border-gray-200 pb-2 text-sm font-bold uppercase tracking-wider text-slate-900">Entradas y Notas Recientes del Sitio</h2>
                    <ul class="space-y-4 text-sm leading-relaxed text-slate-700">
                        <li class="border-b border-gray-100 pb-4">Reconocen a tres coculenses con los Distintivos al Compromiso Comunitario</li>
                        <li class="border-b border-gray-100 pb-4">Gobierno de Cocula anuncia nuevo programa de rehabilitación de calles con recursos municipales</li>
                        <li class="border-b border-gray-100 pb-4">Cocula impulsa la prevención del cáncer de mama y cervicouterino con jornada de concientización</li>
                        <li>Mariachi Sol de Mi Tierra obtiene el tercer lugar en concurso infantil y juvenil en Puerto Vallarta</li>
                    </ul>
                </section>
            </aside>
        </div>
    </main>
@endsection
