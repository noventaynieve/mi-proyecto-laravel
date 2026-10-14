@extends('layouts.municipal')

@section('title', 'Contacto')

@section('content')
    <main class="mx-auto max-w-4xl px-4 py-8">
        <section class="institutional-card">
            <h1 class="mb-4 border-b-2 border-teal-600 pb-2 text-3xl font-bold text-slate-800">Formulario de Contacto</h1>
            <p class="mb-6 text-sm text-slate-600">
                @if (isset($nombre) && $nombre !== 'Usuario')
                    Hola, {{ $nombre }}.
                @endif
                Este formulario es una demostración: puedes probar la validación, pero el mensaje no se envía ni se guarda. No ingreses datos reales.
            </p>

            <form action="#" method="POST" class="space-y-4" data-client-validation-only>
                @csrf
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="contact-name" class="mb-1 block text-xs font-bold uppercase text-slate-700">Nombre completo</label>
                        <input id="contact-name" type="text" name="nombre" required minlength="2" maxlength="120" autocomplete="name" class="w-full rounded border border-gray-300 p-2 text-sm">
                    </div>
                    <div>
                        <label for="contact-email" class="mb-1 block text-xs font-bold uppercase text-slate-700">Correo electrónico</label>
                        <input id="contact-email" type="email" name="correo" required maxlength="254" autocomplete="email" class="w-full rounded border border-gray-300 p-2 text-sm">
                    </div>
                </div>
                <div>
                    <label for="contact-department" class="mb-1 block text-xs font-bold uppercase text-slate-700">Dependencia o área de interés</label>
                    <select id="contact-department" name="dependencia" required class="w-full rounded border border-gray-300 p-2 text-sm">
                        <option value="" selected disabled>Selecciona una dependencia</option>
                        <option value="presidencia">Presidencia Municipal</option>
                        <option value="sindicatura">Sindicatura</option>
                        <option value="obras_publicas">Obras Públicas</option>
                        <option value="registro_civil">Registro Civil</option>
                    </select>
                </div>
                <div>
                    <label for="contact-message" class="mb-1 block text-xs font-bold uppercase text-slate-700">Mensaje o comentario</label>
                    <textarea id="contact-message" name="mensaje" rows="4" required minlength="10" maxlength="2000" class="w-full rounded border border-gray-300 p-2 text-sm"></textarea>
                </div>
                <p data-validation-status hidden role="status" aria-live="polite" tabindex="-1" class="rounded border border-blue-200 bg-blue-50 p-3 text-sm text-blue-900"></p>
                <button type="submit" data-validation-submit disabled class="w-full rounded bg-amber-700 px-4 py-2 font-semibold text-white hover:bg-amber-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-700 disabled:cursor-not-allowed disabled:opacity-60">Validar mensaje de demostración</button>
                <noscript>
                    <p class="text-sm text-amber-800">Activa JavaScript para habilitar la validación. Esta página no envía mensajes.</p>
                </noscript>
            </form>
        </section>
    </main>
@endsection
