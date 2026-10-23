@extends('layouts.municipal')

@section('title', 'Pagar Agua y Predial / Trámites Municipales - Gobierno de Cocula')

@section('content')
    <main class="mx-auto max-w-7xl space-y-10 px-4 py-8">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <div class="space-y-10 lg:col-span-2">
                <section class="space-y-6 rounded-lg border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                    <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">
                        PAGAR AGUA Y PREDIAL
                    </h1>

                    <p class="text-justify text-xs font-semibold uppercase leading-relaxed text-slate-700 sm:text-sm">
                        Bienvenidos al sistema de pago en línea, que el municipio de Cocula, Jal., en coordinación con el Departamento de Agua Potable y Catastro, pone a disposición de toda la ciudadanía de esta localidad. Desde donde le ofrece la posibilidad de realizar pagos anuales, pagos ordinarios, consultar y descargar estados de cuenta y facturas. Todo desde cualquier ubicación, como su casa u oficina, dentro y fuera del país, las 24 horas del día, sin hacer traslados ni filas, de forma rápida y segura.
                    </p>

                    <p class="pt-2 text-xs font-medium uppercase text-slate-600 sm:text-sm">
                        Para realizar tus pagos en línea, necesitamos que tengas a la mano qué servicio quieres pagar y tu número de cuenta de agua o predial.
                    </p>

                    <div class="space-y-3 pt-2">
                        <p class="text-xs font-bold uppercase text-slate-800 sm:text-sm">
                            1 - En la parte superior de tu recibo encontrarás el número de cuenta (imagen 1: cuenta de agua potable).
                        </p>
                        <div class="overflow-hidden rounded border border-gray-300 shadow-inner">
                            @if (is_file(public_path('images/recibos/recibo-agua.jpg')))
                                <img
                                    src="{{ asset('images/recibos/recibo-agua.jpg') }}"
                                    alt="Ejemplo de recibo de agua potable con el número de cuenta"
                                    class="h-auto w-full object-contain"
                                >
                            @else
                                <p class="bg-slate-50 p-6 text-center text-xs text-slate-600">
                                    Imagen de ejemplo pendiente. Agrega el archivo <code>public/images/recibos/recibo-agua.jpg</code>.
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-3 pt-2">
                        <p class="text-xs font-bold uppercase text-slate-800 sm:text-sm">
                            2 - En la parte superior de tu recibo encontrarás el número de cuenta (imagen 2: cuenta predial).
                        </p>
                        <div class="overflow-hidden rounded border border-gray-300 shadow-inner">
                            @if (is_file(public_path('images/recibos/recibo-predial.jpg')))
                                <img
                                    src="{{ asset('images/recibos/recibo-predial.jpg') }}"
                                    alt="Ejemplo de recibo predial con el número de cuenta"
                                    class="h-auto w-full object-contain"
                                >
                            @else
                                <p class="bg-slate-50 p-6 text-center text-xs text-slate-600">
                                    Imagen de ejemplo pendiente. Agrega el archivo <code>public/images/recibos/recibo-predial.jpg</code>.
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-4 pt-2">
                        <p class="text-justify text-xs font-bold uppercase text-slate-800 sm:text-sm">
                            3 - Si ya tienes los datos listos, ingresa a la siguiente liga para efectuar tu pago en línea de manera segura y desde tu hogar.
                        </p>
                        <div class="flex justify-center py-4">
                            <a
                                href="{{ route('tramites.predial') }}"
                                class="rounded-lg bg-[#f98d1a] px-8 py-3.5 text-center text-sm font-bold uppercase tracking-wide text-white shadow-md transition-colors duration-200 hover:bg-[#e07b10] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#e07b10] sm:text-base"
                            >
                                Pagos en línea Cocula Digital
                            </a>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-4">
                        <p class="text-xs font-bold uppercase text-slate-800 sm:text-sm">
                            4 - Después de haber realizado el pago digital, recibirás en tu correo electrónico el recibo oficial.
                        </p>
                    </div>

                    <div class="pt-1">
                        <p class="text-xs font-bold uppercase text-slate-800 sm:text-sm">
                            5 - En caso de no recibirlo, o para atender dudas y aclaraciones, envía un correo electrónico a:
                            <a href="mailto:informatica@cocula.gob.mx" class="font-semibold lowercase text-[#0b435b] hover:underline">
                                informatica@cocula.gob.mx
                            </a>
                        </p>
                    </div>
                </section>

                <section class="space-y-6 rounded-lg border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                    <div class="border-b pb-4">
                        <h2 class="text-2xl font-bold text-slate-900">
                            Pago de Servicios y Trámites Municipales
                        </h2>
                        <p class="mt-2 text-xs text-slate-600 sm:text-sm">
                            Realiza el pago de tus impuestos y contribuciones municipales de manera digital.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <article class="space-y-3 rounded-lg border border-slate-200 bg-slate-50 p-5">
                            <h3 class="text-base font-bold text-slate-900">Pago de Predial</h3>
                            <p class="text-xs text-slate-600">
                                Ingresa tu cuenta catastral para conocer tu saldo e imprimir tu recibo.
                            </p>
                            <div class="pt-2">
                                <a
                                    href="{{ route('tramites.predial') }}"
                                    class="inline-block rounded bg-[#eab308] px-4 py-2 text-xs font-bold text-slate-900 shadow-sm transition-colors hover:bg-[#ca8a04]"
                                >
                                    Pagar Predial
                                </a>
                            </div>
                        </article>

                        <article class="space-y-3 rounded-lg border border-slate-200 bg-slate-50 p-5">
                            <h3 class="text-base font-bold text-slate-900">Licencias Municipales</h3>
                            <p class="text-xs text-slate-600">
                                Refrendo de giros comerciales y consulta de requisitos.
                            </p>
                            <div class="pt-2">
                                <a
                                    href="{{ route('solicitud-licencia') }}"
                                    class="inline-flex rounded bg-amber-500 px-4 py-2 text-xs font-bold text-gray-900 transition-colors hover:bg-amber-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-700"
                                >
                                    Probar formulario de licencia
                                </a>
                            </div>
                        </article>

                        <article class="space-y-3 rounded-lg border border-slate-200 bg-slate-50 p-5 md:col-span-2">
                            <h3 class="text-base font-bold text-slate-900">Agua Potable y Servicios</h3>
                            <p class="text-xs text-slate-600">
                                Consulta información de pagos y reportes de servicio de agua.
                            </p>
                            <div class="pt-2">
                                <a
                                    href="{{ route('tramites.predial') }}"
                                    class="inline-block rounded bg-[#eab308] px-4 py-2 text-xs font-bold text-slate-900 shadow-sm transition-colors hover:bg-[#ca8a04]"
                                >
                                    Ir a Servicios
                                </a>
                            </div>
                        </article>
                    </div>

                    <p id="services-unavailable" class="border-t pt-4 text-xs text-slate-500">
                        Los pagos y las consultas se habilitarán cuando estén disponibles en estas tarjetas. El formulario de licencia solo permite probar la validación y no envía solicitudes.
                    </p>
                </section>
            </div>

            <aside class="space-y-6">
                <section class="sidebar-box space-y-3">
                    <h2 class="border-b pb-2 text-sm font-bold uppercase tracking-wider text-slate-900">
                        Entradas del sitio
                    </h2>
                    <label for="tramites-entries-month" class="sr-only">Elegir el mes de las entradas</label>
                    <select id="tramites-entries-month" class="w-full rounded border border-gray-300 bg-white p-2 text-xs text-slate-600">
                        <option value="">Elegir el mes</option>
                        <option value="oct-2026">Octubre 2026</option>
                        <option value="sep-2026">Septiembre 2026</option>
                    </select>
                </section>
            </aside>
        </div>
    </main>
@endsection
