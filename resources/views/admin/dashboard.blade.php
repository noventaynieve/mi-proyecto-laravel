@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div x-data="{ pestanaActiva: 'noticias' }" class="space-y-8">
        <header>
            <h1 class="text-2xl font-extrabold text-slate-900 sm:text-3xl">Bienvenido al Control General</h1>
            <p class="mt-2 text-sm text-slate-600">Sistema central de administración del sitio web de Cocula, Jalisco.</p>
        </header>

        <section aria-label="Estadísticas del portal" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
            <article @click="pestanaActiva = 'noticias'" :class="pestanaActiva === 'noticias' ? 'border-l-4 border-blue-600 bg-blue-50/30' : 'bg-white'" class="cursor-pointer rounded-lg border border-slate-200 p-5 shadow-sm transition">
                <h2 class="text-sm font-semibold text-slate-600">Noticias publicadas</h2>
                <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $stats['total_noticias'] }}</p>
            </article>
            <article @click="pestanaActiva = 'usuarios'" :class="pestanaActiva === 'usuarios' ? 'border-l-4 border-purple-600 bg-purple-50/30' : 'bg-white'" class="cursor-pointer rounded-lg border border-slate-200 p-5 shadow-sm transition">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="text-sm font-semibold text-slate-600">Usuarios con acceso activo</h2>
                    <span class="rounded bg-purple-100 px-2 py-0.5 text-[10px] font-semibold text-purple-700">Ver quiénes son</span>
                </div>
                <p class="mt-2 text-3xl font-extrabold text-slate-900">{{ $stats['total_usuarios'] }}</p>
            </article>
        </section>

        <section x-show="pestanaActiva === 'usuarios'" x-cloak class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <header class="flex items-center justify-between gap-3 border-b border-slate-200 bg-slate-50 px-5 py-4">
                <h2 class="flex items-center gap-2 text-sm font-bold text-slate-800">
                    <span class="h-2.5 w-2.5 rounded-full bg-emerald-500 animate-ping"></span>
                    Usuarios registrados con permisos de acceso
                </h2>
                <span class="text-xs text-slate-500">Total: {{ $stats['total_usuarios'] }} cuentas</span>
            </header>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left text-xs">
                    <thead class="border-b border-slate-200 bg-slate-100 text-slate-600">
                        <tr>
                            <th scope="col" class="px-4 py-3 font-bold">Nombre / usuario</th>
                            <th scope="col" class="px-4 py-3 font-bold">Correo electrónico</th>
                            <th scope="col" class="px-4 py-3 font-bold">Rol / permisos</th>
                            <th scope="col" class="px-4 py-3 font-bold">Estado</th>
                            <th scope="col" class="px-4 py-3 font-bold">Última actividad</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($usuariosActivos as $user)
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 font-bold text-slate-900">
                                    <div class="flex items-center gap-2">
                                        <div class="flex h-7 w-7 items-center justify-center rounded-full bg-slate-800 text-[10px] font-bold uppercase text-white">
                                            {{ Str::upper(Str::substr($user->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-3 font-mono text-slate-600">{{ $user->email }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex rounded-md border border-slate-200 bg-slate-100 px-2.5 py-1 text-[10px] font-bold uppercase text-slate-700">
                                        {{ $user->roleLabel() }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if (auth()->id() === $user->id)
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-200 bg-emerald-100 px-2 py-0.5 text-[10px] font-bold text-emerald-800">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                                            En línea (sesión actual)
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-100 px-2 py-0.5 text-[10px] font-bold text-slate-600">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            Registrado
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-slate-500">
                                    {{ $user->updated_at ? $user->updated_at->diffForHumans() : 'Reciente' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-slate-400">No hay usuarios registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section x-show="pestanaActiva === 'noticias'" x-cloak class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <header class="border-b border-slate-200 px-5 py-4">
                <h2 class="text-lg font-bold text-slate-900">Últimas publicaciones de noticias</h2>
            </header>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-600">
                        <tr>
                            <th scope="col" class="px-5 py-3">Título</th>
                            <th scope="col" class="px-5 py-3">Categoría</th>
                            <th scope="col" class="px-5 py-3">Fecha</th>
                            <th scope="col" class="px-5 py-3">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($ultimasNoticias as $noticia)
                            <tr>
                                <td class="px-5 py-3 font-semibold text-slate-800">{{ $noticia->titulo }}</td>
                                <td class="px-5 py-3">{{ $noticia->categoria->nombre }}</td>
                                <td class="whitespace-nowrap px-5 py-3 text-slate-600">{{ $noticia->fecha_publicacion->format('d/m/Y') }}</td>
                                <td class="px-5 py-3">
                                    @if (! $noticia->publicado)
                                        Borrador
                                    @elseif ($noticia->fecha_publicacion->isFuture())
                                        Programada
                                    @else
                                        Publicada
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-slate-600">Todavía no hay noticias registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection
