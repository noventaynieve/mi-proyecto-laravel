@extends('layouts.municipal')

@section('title', 'Comité de Pueblo Mágico')

@section('content')
    @php
        $integrantes = [
            'LUIS ARMANDO ALDANA GONZALEZ',
            'JUAN MANUEL SEVILLA GONZALEZ',
            'MARIA CRISTINA RAMIREZ BARRAZA',
            'AURORA YURIDIA VALADEZ PLAZOLA',
            'DOLORES CATALINA IBARRA CORTEZ',
            'MARIA LUISA GABRIELA RAMIREZ OLIVA',
            'VICTOR HUGO MONTES BARBOZA',
            'LANCELOT NANDINO GUTIERREZ',
            'LUIS ALBERTO RAMIREZ BARRAZA',
            'JOSE RAFAEL RUBIO IBARRA',
            'CARLOS ALBERTO ACOSTA GALLEGOS',
            'DIEGO MIGUEL GARCIA HERNANDEZ',
            'MIGUEL RAFAEL FLETES PALACIOS',
        ];
    @endphp

    <main class="mx-auto max-w-7xl space-y-8 px-4 py-8">
        <section class="institutional-card space-y-6">
            <header class="space-y-2 border-b border-gray-200 pb-4">
                <p class="text-xs font-bold uppercase tracking-wider text-amber-700">Información municipal</p>
                <h1 class="text-2xl font-extrabold text-slate-900 sm:text-3xl">Comité de Pueblo Mágico</h1>
            </header>

            <div class="space-y-4 text-sm leading-relaxed text-slate-700">
                <p>
                    El Comité de Pueblo Mágico de Cocula fue instalado en el municipio de Cocula, Jalisco, el viernes 28 de febrero de 2025.
                </p>
                <p>
                    Lo anterior, con fundamento en el reglamento de pueblos mágicos en lo establecido por los artículos 25 de la Constitución Política de los Estados Unidos Mexicanos; 1, 2, 3 párrafo 1 fracción I, 5, 6, 7 párrafo 1 fracción III, 14, 15, 16 párrafo 1 fracción XVII y 33 de la Ley Orgánica del Poder Ejecutivo del estado de Jalisco; así como, lo dispuesto por las Cláusulas Cuarta y Quinta de las Reglas Generales para la Integración y Funcionamiento de los Comités Ciudadanos de Pueblos Mágicos.
                </p>
                <p>Acatando también los lineamientos del punto XI segundo párrafo, página 2-10:</p>
            </div>

            <blockquote class="space-y-4 rounded-lg border-l-4 border-amber-600 bg-amber-50 p-5 text-sm leading-relaxed text-slate-700">
                <p>
                    <strong>XI.</strong> Que los “Comités Ciudadanos de los Pueblos Mágicos” estarán conformados por al menos 5 (cinco) y máximo 7 (siete) miembros titulares, integrados de la manera siguiente:
                </p>
                <ul class="list-disc space-y-2 pl-5">
                    <li><strong>Una Presidencia:</strong> que será ocupada por el Presidente Municipal o, por el Servidor Público que esté tenga a bien designar, quien contará con voz y voto de calidad.</li>
                    <li><strong>Una Coordinación:</strong> que será ocupada por la persona que sea designada por los demás integrantes del Comité Ciudadano, quien contará con voz y voto.</li>
                    <li><strong>Una Secretaría Técnica:</strong> que será ocupada por la persona responsable del área de Turismo del municipio, quien contará solo con voz.</li>
                    <li><strong>Hasta cuatro Vocalías Ciudadanas:</strong> que serán ocupadas por las personas que resulten seleccionadas a través de la Convocatoria respectiva, quienes contarán con voz y voto.</li>
                </ul>
            </blockquote>
        </section>

        <section class="institutional-card space-y-4">
            <h2 class="border-b border-gray-200 pb-3 text-xl font-bold text-slate-900">Integrantes del Comité</h2>
            <ul class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($integrantes as $integrante)
                    <li class="rounded border border-gray-200 bg-slate-50 p-3 text-sm font-semibold text-slate-800">{{ $integrante }}</li>
                @endforeach
            </ul>
        </section>
    </main>
@endsection
