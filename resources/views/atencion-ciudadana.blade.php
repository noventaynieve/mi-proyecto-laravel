@extends('layouts.municipal')

@section('title', 'Atención Ciudadana')

@section('content')
    <main class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 py-8 lg:grid-cols-3">
        <section class="institutional-card lg:col-span-2">
            <h1 class="mb-4 border-b-2 border-teal-600 pb-2 text-3xl font-bold text-slate-800">Atención Ciudadana y Reportes</h1>
            <div class="mb-6 rounded-lg border border-amber-300 bg-amber-50 p-5 text-slate-800" role="status">
                <h2 class="font-bold">Formulario de demostración: no se reciben reportes</h2>
                <p class="mt-2 text-sm leading-relaxed">
                    Puedes probar la validación de los campos, pero esta página no envía ni guarda la información. No escribas datos personales reales. Para reportar una incidencia, comunícate con las oficinas municipales.
                </p>
            </div>

            <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4" data-client-validation-only>
                @csrf
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="report-name" class="mb-1 block text-xs font-bold uppercase text-slate-700">Nombre completo</label>
                        <input id="report-name" type="text" name="nombre" required minlength="2" maxlength="120" autocomplete="name" class="w-full rounded border border-gray-300 p-2 text-sm focus:ring-2 focus:ring-gobierno-blue">
                    </div>
                    <div>
                        <label for="report-phone" class="mb-1 block text-xs font-bold uppercase text-slate-700">Teléfono de contacto</label>
                        <input id="report-phone" type="tel" name="telefono" required pattern="[0-9+() .-]{7,20}" maxlength="20" title="Usa entre 7 y 20 números o caracteres de teléfono." autocomplete="tel" class="w-full rounded border border-gray-300 p-2 text-sm focus:ring-2 focus:ring-gobierno-blue">
                    </div>
                </div>
                <div>
                    <label for="report-type" class="mb-1 block text-xs font-bold uppercase text-slate-700">Tipo de incidencia</label>
                    <select id="report-type" name="tipo_incidencia" required class="w-full rounded border border-gray-300 p-2 text-sm focus:ring-2 focus:ring-gobierno-blue">
                        <option value="" selected disabled>Selecciona una opción</option>
                        <option value="alumbrado">Falla en alumbrado público</option>
                        <option value="bacheo">Bacheo / mantenimiento de calles</option>
                        <option value="fuga_agua">Fuga de agua potable / drenaje</option>
                        <option value="basura">Recolección de basura</option>
                    </select>
                </div>
                <div>
                    <label for="report-location" class="mb-1 block text-xs font-bold uppercase text-slate-700">Ubicación, colonia o referencias</label>
                    <input id="report-location" type="text" name="ubicacion" required maxlength="255" placeholder="Ej. Calle Hidalgo 45, Col. Centro" class="w-full rounded border border-gray-300 p-2 text-sm">
                </div>
                <div>
                    <label for="report-description" class="mb-1 block text-xs font-bold uppercase text-slate-700">Descripción del reporte</label>
                    <textarea id="report-description" name="descripcion" rows="4" required minlength="10" maxlength="2000" class="w-full rounded border border-gray-300 p-2 text-sm"></textarea>
                </div>
                <div>
                    <label for="report-photo" class="mb-1 block text-xs font-bold uppercase text-slate-700">Evidencia fotográfica (opcional, máximo 5 MB)</label>
                    <input id="report-photo" type="file" name="fotografia" accept="image/jpeg,image/png,image/webp" data-max-size="5242880" class="w-full text-xs text-slate-500">
                </div>
                <p data-validation-status hidden role="status" aria-live="polite" tabindex="-1" class="rounded border border-blue-200 bg-blue-50 p-3 text-sm text-blue-900"></p>
                <button type="submit" data-validation-submit disabled class="w-full rounded bg-amber-700 px-4 py-2 font-semibold text-white hover:bg-amber-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-700 disabled:cursor-not-allowed disabled:opacity-60">Validar reporte de demostración</button>
                <noscript>
                    <p class="text-sm text-amber-800">Activa JavaScript para habilitar la validación. Este formulario no envía reportes.</p>
                </noscript>
            </form>

            <section class="mt-6 border-t pt-5">
                <h2 class="mb-3 text-lg font-semibold text-slate-800">Tipos de reporte que podrán canalizarse</h2>
                <ul class="grid grid-cols-1 gap-3 text-sm text-slate-600 sm:grid-cols-2">
                    <li class="rounded border bg-slate-50 p-3">Alumbrado público</li>
                    <li class="rounded border bg-slate-50 p-3">Bacheo y calles</li>
                    <li class="rounded border bg-slate-50 p-3">Agua potable y alcantarillado</li>
                    <li class="rounded border bg-slate-50 p-3">Recolección de basura</li>
                </ul>
            </section>
        </section>

        <aside>
            <section class="sidebar-box">
                <h2 class="mb-3 font-bold text-slate-800">Contacto municipal</h2>
                <p class="text-sm text-slate-600">Palacio Municipal, Hidalgo #1, Centro, Cocula, Jalisco.</p>
                <p class="mt-3 text-sm text-slate-600">Teléfono: <a class="font-semibold text-teal-700 hover:underline" href="tel:+523757520000">(375) 752 0000</a></p>
                <p class="mt-2 text-sm text-slate-600">Correo: <a class="font-semibold text-teal-700 hover:underline" href="mailto:contacto@cocula.gob.mx">contacto@cocula.gob.mx</a></p>
            </section>
        </aside>
    </main>
@endsection
