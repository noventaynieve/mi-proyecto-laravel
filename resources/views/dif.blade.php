@extends('layouts.municipal')

@section('title', 'DIF Municipal')

@section('content')
    @php
        $directoraPhoto = 'img/dif/belia-alicia-flores-ramos.jpg';
    @endphp

    <main class="mx-auto max-w-5xl space-y-8 px-4 py-8">
        <section class="institutional-card space-y-8">
            <header class="grid grid-cols-1 items-center gap-6 border-b border-gray-200 pb-8 sm:grid-cols-3">
                <div class="mx-auto flex aspect-[3/4] w-full max-w-56 items-center justify-center overflow-hidden rounded-lg border border-gray-200 bg-slate-100 sm:mx-0">
                    @if (is_file(public_path($directoraPhoto)))
                        <img
                            src="{{ asset($directoraPhoto) }}"
                            alt="Belia Alicia Flores Ramos, Presidenta del DIF Municipal de Cocula"
                            class="h-full w-full object-cover"
                        >
                    @else
                        <span class="text-5xl font-bold tracking-widest text-slate-400" role="img" aria-label="Fotografía de la presidenta del DIF pendiente de publicación">
                            BF
                        </span>
                    @endif
                </div>

                <div class="space-y-3 text-center sm:col-span-2 sm:text-left">
                    <p class="text-sm font-bold uppercase tracking-wider text-amber-700">Sistema para el Desarrollo Integral de la Familia</p>
                    <h1 class="text-2xl font-extrabold uppercase text-slate-900 sm:text-3xl">Belia Alicia Flores Ramos</h1>
                    <p class="text-base font-semibold uppercase tracking-wide text-slate-700">Presidenta del DIF Municipal de Cocula</p>
                    @if (! is_file(public_path($directoraPhoto)))
                        <p class="text-sm text-slate-500">Fotografía pendiente de publicación.</p>
                    @endif
                </div>
            </header>

            <article class="space-y-5 text-sm leading-relaxed text-slate-700 sm:text-base">
                <p>Queridos ciudadanos de Cocula:</p>
                <p>Es un honor dirigirme a ustedes como presidenta del DIF Municipal de Cocula.</p>
                <p>Quiero expresar mi sincero agradecimiento por la confianza depositada en su servidora.</p>
                <p>Su apoyo y colaboración constante en nuestras iniciativas para mejorar la calidad de vida en nuestra comunidad será indispensable.</p>
                <p>Nuestra prioridad será la atención a las familias y el fortalecimiento de nuestros programas sociales para los grupos más vulnerables.</p>
                <p>Les invito a seguir participando activamente en las actividades del DIF. Su voz y sus ideas son fundamentales para construir un Cocula más fuerte y unido. Recuerden que cada pequeño esfuerzo cuenta y que juntos podemos enfrentar los retos que se nos presenten.</p>
                <p>De la mano del Ayuntamiento que preside mi esposo el C. Luis Armando Aldana González, haremos un equipo para servir a nuestra comunidad sin distinción y sin privilegio.</p>
                <p>Buscaremos gestionar los recursos para que más personas se beneficien de los programas que ofrece el DIF Municipal de Cocula.</p>
                <p>Agradezco su confianza y les animo a seguir trabajando juntos por el bienestar de todos.</p>
            </article>

            <footer class="border-t border-gray-200 pt-5 text-sm text-slate-700">
                <p>Con cariño,</p>
                <p class="mt-1 font-bold text-slate-900">Belia Alicia Flores Ramos</p>
                <p class="italic">Presidenta del DIF Municipal de Cocula</p>
            </footer>
        </section>
    </main>
@endsection
