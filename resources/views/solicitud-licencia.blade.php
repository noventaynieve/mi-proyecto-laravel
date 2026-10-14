@extends('layouts.municipal')

@section('title', 'Solicitud de Licencia Municipal')

@section('content')
    <main class="mx-auto max-w-4xl px-4 py-8">
        <section class="institutional-card">
            <h1 class="mb-4 border-b-2 border-teal-600 pb-2 text-3xl font-bold text-slate-800">Solicitud de Licencia Comercial</h1>
            <div class="mb-6 rounded-lg border border-amber-300 bg-amber-50 p-4 text-sm text-slate-800" role="status">
                Formulario de demostración: puedes probar la validación, pero la solicitud y los archivos no se envían ni se guardan. No ingreses datos reales.
            </div>

            <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4" data-client-validation-only>
                @csrf
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="business-name" class="mb-1 block text-xs font-bold uppercase text-slate-700">Nombre comercial del negocio</label>
                        <input id="business-name" type="text" name="nombre_negocio" required minlength="2" maxlength="150" class="w-full rounded border border-gray-300 p-2 text-sm">
                    </div>
                    <div>
                        <label for="business-rfc" class="mb-1 block text-xs font-bold uppercase text-slate-700">RFC del titular</label>
                        <input id="business-rfc" type="text" name="rfc" required minlength="12" maxlength="13" pattern="[A-Za-z&Ññ]{3,4}[0-9]{6}[A-Za-z0-9]{3}" title="Escribe un RFC de persona física o moral con formato válido." autocapitalize="characters" class="w-full rounded border border-gray-300 p-2 text-sm">
                    </div>
                </div>
                <div>
                    <label for="business-type" class="mb-1 block text-xs font-bold uppercase text-slate-700">Giro comercial solicitado</label>
                    <select id="business-type" name="giro" required class="w-full rounded border border-gray-300 p-2 text-sm">
                        <option value="" selected disabled>Selecciona un giro</option>
                        <option value="abarrotes">Abarrotes y comercio al por menor</option>
                        <option value="restaurante">Servicios de alimentos / restaurante</option>
                        <option value="servicios">Oficina o servicios profesionales</option>
                    </select>
                </div>
                <div>
                    <label for="business-proof" class="mb-1 block text-xs font-bold uppercase text-slate-700">Comprobante de domicilio (PDF opcional, máximo 5 MB)</label>
                    <input id="business-proof" type="file" name="comprobante_domicilio" accept=".pdf,application/pdf" data-max-size="5242880" class="w-full text-xs text-slate-500">
                </div>
                <p data-validation-status hidden role="status" aria-live="polite" tabindex="-1" class="rounded border border-blue-200 bg-blue-50 p-3 text-sm text-blue-900"></p>
                <button type="submit" data-validation-submit disabled class="w-full rounded bg-amber-700 px-4 py-2 font-semibold text-white hover:bg-amber-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-700 disabled:cursor-not-allowed disabled:opacity-60">Validar solicitud de demostración</button>
                <noscript>
                    <p class="text-sm text-amber-800">Activa JavaScript para habilitar la validación. Esta página no envía solicitudes.</p>
                </noscript>
            </form>
        </section>
    </main>
@endsection
