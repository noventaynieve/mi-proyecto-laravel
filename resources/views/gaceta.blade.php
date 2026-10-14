@extends('layouts.municipal')

@section('title', 'Gaceta Municipal')

@section('content')
    <main class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 py-8 lg:grid-cols-3">
        <section class="institutional-card lg:col-span-2">
            <h1 class="mb-4 border-b-2 border-teal-600 pb-2 text-3xl font-bold text-slate-800">Gaceta Municipal</h1>
            <p class="mb-6 text-sm text-slate-600">Consulta en esta sección los acuerdos, reglamentos y decretos publicados por el Ayuntamiento.</p>

            <div class="overflow-x-auto">
                <table class="institutional-table">
                    <thead>
                        <tr>
                            <th scope="col">Publicación</th>
                            <th scope="col">Fecha</th>
                            <th scope="col">Documento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3" class="text-center text-slate-600">Las publicaciones oficiales se incorporarán cuando estén disponibles para consulta.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <aside>
            <section class="sidebar-box">
                <h2 class="mb-2 font-bold text-slate-800">Edictos y acuerdos</h2>
                <p class="text-sm text-slate-600">Los documentos oficiales estarán disponibles aquí en cuanto sean publicados por el Ayuntamiento.</p>
            </section>
        </aside>
    </main>
@endsection
