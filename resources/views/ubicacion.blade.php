@extends('layouts.municipal')

@section('title', 'Ubicación')

@section('content')
    @php($mapsApiKey = config('services.google_maps.key'))

    <main class="mx-auto max-w-7xl space-y-8 px-4 py-8">
        <header class="space-y-3 rounded-lg border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <p class="text-sm font-bold uppercase tracking-wider text-amber-700">Gobierno de Cocula Jalisco</p>
            <h1 class="text-2xl font-extrabold uppercase tracking-tight text-slate-900 sm:text-3xl">Explorador de Ubicaciones</h1>
            <p class="text-sm leading-relaxed text-slate-600">Consulta el mapa de referencia del centro de Cocula, Jalisco.</p>
        </header>

        <section class="space-y-4">
            @if (filled($mapsApiKey))
                <div class="grid gap-3 md:grid-cols-[minmax(0,1fr)_auto_auto]">
                    <div
                        data-place-autocomplete
                        class="min-w-0"
                        aria-label="Buscar lugares, ciudades o direcciones"
                    ></div>
                    <button
                        type="button"
                        data-map-locate
                        disabled
                        class="rounded bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-700 disabled:cursor-not-allowed disabled:opacity-60"
                    >Ubicación actual</button>
                    <button
                        type="button"
                        data-map-traffic
                        aria-pressed="false"
                        disabled
                        class="rounded bg-emerald-700 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-700 disabled:cursor-not-allowed disabled:opacity-60"
                    >Activar tráfico</button>
                </div>
            @else
                <p class="rounded-lg border border-amber-300 bg-amber-50 p-4 text-sm text-amber-900" role="status">
                    El mapa funciona en modo de consulta. Configura <code>GOOGLE_MAPS_API_KEY</code> para habilitar búsqueda de lugares, geolocalización, marcadores interactivos y tráfico.
                </p>
            @endif

            <div class="overflow-hidden rounded-lg border border-gray-200 bg-slate-200 shadow-sm">
                @if (filled($mapsApiKey))
                    <div
                        data-google-map
                        data-google-maps-api-key="{{ $mapsApiKey }}"
                        role="application"
                        aria-label="Mapa interactivo del centro de Cocula, Jalisco"
                        class="h-[24rem] w-full sm:h-[32rem]"
                    ></div>
                    <iframe
                        data-static-map-fallback
                        src="https://maps.google.com/maps?q=20.3667%2C-103.8167&z=14&output=embed"
                        title="Mapa de referencia del centro de Cocula, Jalisco"
                        class="h-[24rem] w-full sm:h-[32rem]"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen
                        hidden
                    ></iframe>
                @else
                    <iframe
                        src="https://maps.google.com/maps?q=20.3667%2C-103.8167&z=14&output=embed"
                        title="Mapa de referencia del centro de Cocula, Jalisco"
                        class="h-[24rem] w-full sm:h-[32rem]"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen
                    ></iframe>
                @endif
            </div>

            <p data-map-status role="status" aria-live="polite" class="rounded-lg border-l-4 border-teal-700 bg-white p-4 text-sm text-slate-700 shadow-sm">
                @if (filled($mapsApiKey))
                    Cargando mapa interactivo de Google Maps...
                @else
                    Mapa de referencia del centro de Cocula, Jalisco.
                @endif
            </p>

            <aside class="space-y-5 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
                <div class="space-y-2">
                    <h2 class="text-lg font-bold text-slate-900">Centro de Cocula, Jalisco</h2>
                    <p class="text-sm leading-relaxed text-slate-600">Mapa con coordenadas de referencia para ubicar la zona centro. Confirma la dirección exacta antes de trasladarte.</p>
                </div>
                <a
                    href="https://www.google.com/maps/dir/?api=1&amp;destination=20.3667%2C-103.8167"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="inline-flex rounded bg-teal-700 px-4 py-2 text-sm font-semibold text-white hover:bg-teal-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-teal-700"
                >
                    Abrir indicaciones en Google Maps
                </a>
            </aside>
        </section>
    </main>
@endsection
