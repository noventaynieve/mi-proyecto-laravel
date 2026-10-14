@extends('layouts.municipal')

@section('title', 'Solicitud de Información Pública')

@section('content')
    <main class="mx-auto max-w-4xl px-4 py-8">
        <section class="institutional-card">
            <h1 class="mb-4 border-b-2 border-teal-600 pb-2 text-3xl font-bold text-slate-800">Solicitud de Acceso a la Información</h1>
            <div class="mb-6 rounded-lg border border-amber-300 bg-amber-50 p-4 text-sm text-slate-800" role="status">
                Formulario de demostración: puedes probar la validación, pero la solicitud no se envía ni se guarda. No ingreses datos personales reales.
            </div>

            <form action="#" method="POST" class="space-y-4" data-client-validation-only>
                @csrf
                <div>
                    <label for="requester-name" class="mb-1 block text-xs font-bold uppercase text-slate-700">Nombre o seudónimo del solicitante</label>
                    <input id="requester-name" type="text" name="solicitante" required minlength="2" maxlength="120" autocomplete="name" class="w-full rounded border border-gray-300 p-2 text-sm">
                </div>
                <div>
                    <label for="requester-email" class="mb-1 block text-xs font-bold uppercase text-slate-700">Correo electrónico para notificaciones</label>
                    <input id="requester-email" type="email" name="email" required maxlength="254" autocomplete="email" class="w-full rounded border border-gray-300 p-2 text-sm">
                </div>
                <div>
                    <label for="request-details" class="mb-1 block text-xs font-bold uppercase text-slate-700">Descripción de la información solicitada</label>
                    <textarea id="request-details" name="detalle_solicitud" rows="5" required minlength="10" maxlength="3000" placeholder="Especifica los datos, periodos o documentos requeridos." class="w-full rounded border border-gray-300 p-2 text-sm"></textarea>
                </div>
                <div>
                    <label for="request-format" class="mb-1 block text-xs font-bold uppercase text-slate-700">Modalidad de entrega</label>
                    <select id="request-format" name="modalidad" required class="w-full rounded border border-gray-300 p-2 text-sm">
                        <option value="" selected disabled>Selecciona una modalidad</option>
                        <option value="electronica">Vía correo electrónico / sistema</option>
                        <option value="copia_simple">Copia simple en oficina</option>
                        <option value="copia_certificada">Copia certificada</option>
                    </select>
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
