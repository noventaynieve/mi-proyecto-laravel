@extends('layouts.municipal')

@section('title', 'Atención Ciudadana')

@section('content')
    <main class="mx-auto grid max-w-7xl grid-cols-1 gap-8 px-4 py-8 lg:grid-cols-3">
        <section class="institutional-card lg:col-span-2">
            <h1 class="mb-4 border-b-2 border-teal-600 pb-2 text-3xl font-bold text-slate-800">Atención Ciudadana y Reportes</h1>
            <div class="rounded-lg border border-amber-300 bg-amber-50 p-5 text-slate-800" role="status">
                <h2 class="font-bold">Recepción de reportes en línea no disponible</h2>
                <p class="mt-2 text-sm leading-relaxed">
                    Este portal todavía no recibe ni almacena reportes ciudadanos. Para evitar que tu información quede sin atender, no compartas datos personales en un formulario no habilitado. Comunícate con las oficinas municipales para solicitar orientación.
                </p>
            </div>

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
