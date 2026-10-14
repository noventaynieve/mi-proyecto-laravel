@extends('layouts.municipal')

@section('title', 'Transparencia y SEVAC')

@section('content')
    <main class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 py-8 lg:grid-cols-3">
        <section class="institutional-card lg:col-span-2">
            <h1 class="mb-4 border-b border-gray-200 pb-3 text-xl font-bold text-gray-900">Portal de Transparencia y SEVAC</h1>
            <p class="mb-4 text-xs leading-relaxed text-gray-600">
                En cumplimiento con la Ley de Transparencia del Estado de Jalisco, ponemos a disposición de la ciudadanía la información financiera y de rendición de cuentas.
            </p>

            <h2 class="mb-3 mt-6 text-sm font-bold uppercase tracking-wider text-gray-800">Obligaciones comunes</h2>
            <div class="overflow-x-auto">
                <table class="institutional-table">
                    <thead>
                        <tr>
                            <th scope="col">Fracción / Descripción</th>
                            <th scope="col">Ejercicio</th>
                            <th scope="col">Documento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Remuneración bruta y neta de funcionarios</td>
                            <td>2026</td>
                            <td><span class="text-sm text-gray-500">Documento pendiente de publicación</span></td>
                        </tr>
                        <tr>
                            <td>Presupuesto asignado e informes SEVAC</td>
                            <td>2026</td>
                            <td><span class="text-sm text-gray-500">Documento pendiente de publicación</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
