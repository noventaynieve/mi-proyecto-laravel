@extends('layouts.admin')

@section('title', 'Registro de formularios')

@php
    $panelRegistros = collect($solicitudes->items())->map(function ($solicitud): array {
        return [
            'id' => $solicitud->id,
            'folio' => $solicitud->folio,
            'fecha' => $solicitud->created_at?->format('d M Y') ?? '',
            'origen' => $solicitud->modulo_origen,
            'origenLabel' => match ($solicitud->modulo_origen) {
                'DIF' => 'DIF',
                'TRANSPARENCIA' => 'Transparencia',
                'ACCESIBILIDAD' => 'Atención Ciudadana',
                default => 'Contacto General',
            },
            'solicitante' => $solicitud->nombre_completo,
            'contacto' => trim(($solicitud->email ?? '').($solicitud->telefono ? ' · '.$solicitud->telefono : '')),
            'asunto' => $solicitud->asunto,
            'mensaje' => $solicitud->mensaje_solicitud,
            'estatus' => match ($solicitud->estatus) {
                'PENDIENTE' => 'Pendiente',
                'EN_REVISION' => 'En Proceso',
                'ATENDIDO' => 'Concluido',
                default => 'Rechazado',
            },
            'observaciones' => $solicitud->observaciones_internas ?? '',
            'url' => route('admin.formularios.updateEstatus', ['solicitudFormulario' => $solicitud, ...request()->query()]),
        ];
    })->values()->all();
@endphp

@section('content')
    <div x-data="panelRegistros()" class="space-y-6" x-cloak>
        <style>
            [x-cloak] { display: none !important; }
        </style>

        <header class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 sm:text-3xl">Registro General de Formularios</h1>
                <p class="mt-1 text-sm text-slate-600">Concentrado administrativo para seguimiento de solicitudes ciudadanas.</p>
            </div>
            <span class="w-fit rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-800">
                Seguimiento administrativo
            </span>
        </header>

        <section aria-label="Resumen de solicitudes" class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article @click="setFiltroCategoria('todas')" :class="filtroActual === 'todas' ? 'ring-2 ring-blue-600 bg-blue-50/40 border-blue-200' : 'bg-white border-slate-200 hover:border-slate-300'" class="cursor-pointer rounded-xl border p-5 shadow-sm transition-all duration-150">
                <h2 class="text-[11px] font-bold uppercase tracking-wide text-slate-500">Total de solicitudes</h2>
                <div class="mt-3 flex items-baseline justify-between">
                    <p class="text-3xl font-extrabold text-slate-900" x-text="totales.todos"></p>
                    <span class="rounded bg-blue-100 px-2 py-0.5 text-[10px] font-semibold text-blue-800">Ver todas</span>
                </div>
            </article>

            <article @click="setFiltroCategoria('pendiente')" :class="filtroActual === 'pendiente' ? 'ring-2 ring-amber-500 bg-amber-50/40 border-amber-200' : 'bg-white border-slate-200 hover:border-slate-300'" class="cursor-pointer rounded-xl border p-5 shadow-sm transition-all duration-150">
                <h2 class="text-[11px] font-bold uppercase tracking-wide text-amber-700">Pendientes de revisión</h2>
                <div class="mt-3 flex items-baseline justify-between">
                    <p class="text-3xl font-extrabold text-amber-700" x-text="totales.pendientes"></p>
                    <span class="rounded bg-amber-100 px-2 py-0.5 text-[10px] font-semibold text-amber-800">Filtrar</span>
                </div>
            </article>

            <article @click="setFiltroCategoria('dif')" :class="filtroActual === 'dif' ? 'ring-2 ring-rose-600 bg-rose-50/40 border-rose-200' : 'bg-white border-slate-200 hover:border-slate-300'" class="cursor-pointer rounded-xl border p-5 shadow-sm transition-all duration-150">
                <h2 class="text-[11px] font-bold uppercase tracking-wide text-rose-700">Módulo DIF</h2>
                <div class="mt-3 flex items-baseline justify-between">
                    <p class="text-3xl font-extrabold text-rose-700" x-text="totales.dif"></p>
                    <span class="rounded bg-rose-100 px-2 py-0.5 text-[10px] font-semibold text-rose-800">Filtrar</span>
                </div>
            </article>

            <article @click="setFiltroCategoria('transparencia')" :class="filtroActual === 'transparencia' ? 'ring-2 ring-emerald-600 bg-emerald-50/40 border-emerald-200' : 'bg-white border-slate-200 hover:border-slate-300'" class="cursor-pointer rounded-xl border p-5 shadow-sm transition-all duration-150">
                <h2 class="text-[11px] font-bold uppercase tracking-wide text-emerald-700">Transparencia</h2>
                <div class="mt-3 flex items-baseline justify-between">
                    <p class="text-3xl font-extrabold text-emerald-700" x-text="totales.transparencia"></p>
                    <span class="rounded bg-emerald-100 px-2 py-0.5 text-[10px] font-semibold text-emerald-800">Filtrar</span>
                </div>
            </article>
        </section>

        <div class="flex flex-wrap items-center justify-between gap-4 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="mb-1 block text-[11px] font-medium text-slate-500">Filtrar por módulo</label>
                    <select x-model="filtroModulo" class="rounded-lg border border-slate-300 px-3 py-2 text-xs focus:ring-slate-900">
                        <option value="todos">Todos los módulos</option>
                        <option value="DIF">DIF</option>
                        <option value="TRANSPARENCIA">Transparencia</option>
                        <option value="ACCESIBILIDAD">Atención Ciudadana</option>
                        <option value="CONTACTO_GENERAL">Contacto General</option>
                    </select>
                </div>

                <div>
                    <label class="mb-1 block text-[11px] font-medium text-slate-500">Estatus</label>
                    <select x-model="filtroEstatus" class="rounded-lg border border-slate-300 px-3 py-2 text-xs focus:ring-slate-900">
                        <option value="todos">Todos los estatus</option>
                        <option value="PENDIENTE">Pendiente</option>
                        <option value="EN_REVISION">En Proceso</option>
                        <option value="ATENDIDO">Concluido</option>
                        <option value="RECHAZADO">Rechazado</option>
                    </select>
                </div>

                <button @click="limpiarFiltros()" type="button" class="rounded-lg bg-slate-900 px-4 py-2 text-xs font-bold text-white transition hover:bg-slate-800">
                    Limpiar filtros
                </button>
            </div>

            <div class="text-xs font-medium text-slate-500">
                Mostrando: <span class="font-bold text-slate-800" x-text="registrosFiltrados.length"></span> de <span class="font-bold text-slate-800" x-text="registros.length"></span> registros
            </div>
        </div>

        <form method="GET" action="{{ route('admin.formularios.index') }}" class="flex flex-wrap items-end gap-4 rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
            <div class="min-w-52">
                <label for="modulo" class="mb-1 block text-xs font-semibold text-slate-700">Filtrar por módulo</label>
                <select id="modulo" name="modulo" class="w-full rounded border border-slate-300 p-2 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">Todos los módulos</option>
                    <option value="DIF" @selected(request('modulo') === 'DIF')>DIF Municipal</option>
                    <option value="TRANSPARENCIA" @selected(request('modulo') === 'TRANSPARENCIA')>Transparencia</option>
                    <option value="ACCESIBILIDAD" @selected(request('modulo') === 'ACCESIBILIDAD')>Accesibilidad web</option>
                    <option value="CONTACTO_GENERAL" @selected(request('modulo') === 'CONTACTO_GENERAL')>Contacto ciudadano</option>
                </select>
            </div>

            <div class="min-w-52">
                <label for="estatus" class="mb-1 block text-xs font-semibold text-slate-700">Estatus</label>
                <select id="estatus" name="estatus" class="w-full rounded border border-slate-300 p-2 text-sm focus:ring-2 focus:ring-indigo-500">
                    <option value="">Todos los estatus</option>
                    <option value="PENDIENTE" @selected(request('estatus') === 'PENDIENTE')>Pendiente</option>
                    <option value="EN_REVISION" @selected(request('estatus') === 'EN_REVISION')>En revisión</option>
                    <option value="ATENDIDO" @selected(request('estatus') === 'ATENDIDO')>Atendido</option>
                    <option value="RECHAZADO" @selected(request('estatus') === 'RECHAZADO')>Rechazado</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="rounded bg-slate-800 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-900">
                    Aplicar filtros
                </button>
                <a href="{{ route('admin.formularios.index') }}" class="rounded border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Limpiar
                </a>
            </div>
        </form>

        <section aria-label="Solicitudes registradas" class="overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm text-slate-600">
                    <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-600">
                        <tr>
                            <th scope="col" class="px-4 py-3">Folio / fecha</th>
                            <th scope="col" class="px-4 py-3">Origen</th>
                            <th scope="col" class="px-4 py-3">Solicitante</th>
                            <th scope="col" class="px-4 py-3">Asunto</th>
                            <th scope="col" class="px-4 py-3">Estatus</th>
                            <th scope="col" class="px-4 py-3 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="item in registrosFiltrados" :key="item.id">
                            <tr class="align-top transition-colors hover:bg-slate-50/80">
                                <td class="whitespace-nowrap px-4 py-3 font-mono">
                                    <span class="block font-bold text-slate-900" x-text="item.folio"></span>
                                    <span class="text-xs text-slate-500" x-text="item.fecha"></span>
                                </td>
                                <td class="px-4 py-3">
                                    <span x-text="item.origenLabel" :class="{
                                        'bg-rose-50 text-rose-700 border-rose-200': item.origen === 'DIF',
                                        'bg-emerald-50 text-emerald-700 border-emerald-200': item.origen === 'TRANSPARENCIA',
                                        'bg-blue-50 text-blue-700 border-blue-200': item.origen === 'ACCESIBILIDAD',
                                        'bg-slate-100 text-slate-700 border-slate-200': item.origen === 'CONTACTO_GENERAL'
                                    }" class="inline-flex rounded-md border px-2.5 py-1 text-[10px] font-semibold"></span>
                                </td>
                                <td class="min-w-52 px-4 py-3">
                                    <p class="font-semibold text-slate-800" x-text="item.solicitante"></p>
                                    <p class="text-xs text-slate-500" x-text="item.contacto"></p>
                                </td>
                                <td class="max-w-sm min-w-52 px-4 py-3 text-slate-600">
                                    <div class="font-medium text-slate-800" x-text="item.asunto"></div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-3">
                                    <span :class="{
                                        'bg-amber-100 text-amber-800 border-amber-300': item.estatus === 'Pendiente',
                                        'bg-blue-100 text-blue-800 border-blue-300': item.estatus === 'En Proceso',
                                        'bg-emerald-100 text-emerald-800 border-emerald-300': item.estatus === 'Concluido',
                                        'bg-red-100 text-red-800 border-red-300': item.estatus === 'Rechazado'
                                    }" class="inline-flex rounded-full border px-2.5 py-1 text-[10px] font-bold" x-text="item.estatus"></span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button @click="abrirDetalle(item)" type="button" class="rounded bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700 transition hover:bg-slate-200">
                                            Ver
                                        </button>
                                        <button @click="abrirEditar(item)" type="button" class="rounded bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700 transition hover:bg-blue-100">
                                            Editar
                                        </button>
                                        <button @click="eliminarRegistro(item.id)" type="button" class="rounded bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700 transition hover:bg-rose-100">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>

                        <template x-if="registrosFiltrados.length === 0">
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-sm text-slate-500">
                                    No se encontraron solicitudes para estos filtros.
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <div class="border-t border-slate-200 bg-slate-50 p-4">
                {{ $solicitudes->links() }}
            </div>
        </section>

        <div x-show="modalDetalle" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm">
            <div @click.away="modalDetalle = false" class="w-full max-w-lg rounded-xl border border-slate-100 bg-white p-6 shadow-2xl">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide text-slate-500">Detalle completo</p>
                        <h3 class="mt-1 text-lg font-bold text-slate-900" x-text="registroSeleccionado.folio"></h3>
                    </div>
                    <button @click="modalDetalle = false" type="button" class="rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-600 hover:bg-slate-200">Cerrar</button>
                </div>

                <div class="space-y-3 text-sm text-slate-600">
                    <div class="rounded-lg bg-slate-50 p-3">
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-500">Solicitante</p>
                        <p class="mt-1 font-semibold text-slate-800" x-text="registroSeleccionado.solicitante"></p>
                        <p class="text-xs text-slate-500" x-text="registroSeleccionado.contacto"></p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-3">
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-500">Origen</p>
                        <p class="mt-1 font-semibold text-slate-800" x-text="registroSeleccionado.origenLabel"></p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-3">
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-500">Asunto</p>
                        <p class="mt-1 whitespace-pre-wrap font-medium text-slate-800" x-text="registroSeleccionado.asunto"></p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-3">
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-500">Mensaje</p>
                        <p class="mt-1 whitespace-pre-wrap text-xs leading-relaxed text-slate-600" x-text="registroSeleccionado.mensaje"></p>
                    </div>
                    <div class="rounded-lg bg-slate-50 p-3">
                        <p class="text-[10px] font-bold uppercase tracking-wide text-slate-500">Estatus</p>
                        <p class="mt-1 font-semibold text-slate-800" x-text="registroSeleccionado.estatus"></p>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="modalEditar" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm">
            <div @click.away="modalEditar = false" class="w-full max-w-lg rounded-xl border border-slate-100 bg-white p-6 shadow-2xl">
                <h3 class="mb-4 text-lg font-bold text-slate-900">Editar solicitud - <span x-text="registroSeleccionado.folio"></span></h3>

                <form @submit.prevent="guardarEdicion()" class="space-y-4 text-xs">
                    <div>
                        <label class="mb-1 block font-bold text-slate-700">Nombre del solicitante</label>
                        <input type="text" x-model="registroSeleccionado.solicitante" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-slate-900">
                    </div>

                    <div>
                        <label class="mb-1 block font-bold text-slate-700">Asunto / descripción</label>
                        <textarea x-model="registroSeleccionado.asunto" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-slate-900"></textarea>
                    </div>

                    <div>
                        <label class="mb-1 block font-bold text-slate-700">Estatus del registro</label>
                        <select x-model="registroSeleccionado.estatus" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:ring-slate-900">
                            <option value="Pendiente">Pendiente</option>
                            <option value="En Proceso">En Proceso</option>
                            <option value="Concluido">Concluido</option>
                            <option value="Rechazado">Rechazado</option>
                        </select>
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <button type="button" @click="modalEditar = false" class="rounded-lg border border-slate-300 px-4 py-2 font-bold text-slate-600 hover:bg-slate-50">Cancelar</button>
                        <button type="submit" class="rounded-lg bg-slate-900 px-4 py-2 font-bold text-white hover:bg-slate-800">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function panelRegistros() {
            return {
                filtroActual: 'todas',
                filtroModulo: 'todos',
                filtroEstatus: 'todos',
                modalDetalle: false,
                modalEditar: false,
                registroSeleccionado: null,
                totales: @js($totales),
                registros: @js($panelRegistros),

                setFiltroCategoria(categoria) {
                    this.filtroActual = categoria;

                    if (categoria === 'dif') {
                        this.filtroModulo = 'DIF';
                        this.filtroEstatus = 'todos';
                    } else if (categoria === 'transparencia') {
                        this.filtroModulo = 'TRANSPARENCIA';
                        this.filtroEstatus = 'todos';
                    } else if (categoria === 'pendiente') {
                        this.filtroEstatus = 'PENDIENTE';
                        this.filtroModulo = 'todos';
                    } else {
                        this.limpiarFiltros();
                    }
                },

                limpiarFiltros() {
                    this.filtroActual = 'todas';
                    this.filtroModulo = 'todos';
                    this.filtroEstatus = 'todos';
                },

                get registrosFiltrados() {
                    return this.registros.filter((item) => {
                        const coincideModulo = this.filtroModulo === 'todos' || item.origen === this.filtroModulo;
                        const coincideEstatus = this.filtroEstatus === 'todos' || this.normalizarEstatus(item.estatus) === this.filtroEstatus;

                        return coincideModulo && coincideEstatus;
                    });
                },

                normalizarEstatus(estatus) {
                    const equivalencias = {
                        Pendiente: 'PENDIENTE',
                        'En Proceso': 'EN_REVISION',
                        Concluido: 'ATENDIDO',
                        Rechazado: 'RECHAZADO',
                    };

                    return equivalencias[estatus] ?? estatus;
                },

                abrirDetalle(item) {
                    this.registroSeleccionado = structuredClone(item);
                    this.modalDetalle = true;
                },

                abrirEditar(item) {
                    this.registroSeleccionado = structuredClone(item);
                    this.modalEditar = true;
                },

                guardarEdicion() {
                    const idx = this.registros.findIndex((registro) => registro.id === this.registroSeleccionado.id);

                    if (idx !== -1) {
                        this.registros[idx] = { ...this.registroSeleccionado };
                    }

                    this.modalEditar = false;
                },

                eliminarRegistro(id) {
                    if (window.confirm('¿Estás seguro de que deseas eliminar este registro del sistema?')) {
                        this.registros = this.registros.filter((registro) => registro.id !== id);
                    }
                }
            };
        }
    </script>
@endsection
