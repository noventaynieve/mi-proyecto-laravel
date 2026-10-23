@extends('layouts.municipal')

@section('title', 'Administrar noticias')

@section('content')
    <main class="mx-auto max-w-7xl space-y-6 px-4 py-8">
        <header class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900">Administrar noticias</h1>
                <nav class="mt-2 flex gap-4 text-sm font-semibold text-teal-800">
                    <a href="{{ route('admin.noticias.index') }}" class="underline">Noticias</a>
                    <a href="{{ route('admin.categorias.index') }}" class="hover:underline">Categorías</a>
                </nav>
            </div>
            <a href="{{ route('admin.noticias.create') }}" class="rounded bg-[#0b435b] px-4 py-2 text-sm font-semibold text-white hover:bg-[#083346]">Nueva noticia</a>
        </header>

        @if (session('status'))
            <p role="status" class="rounded border border-green-200 bg-green-50 p-3 text-sm text-green-800">{{ session('status') }}</p>
        @endif

        <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-600">
                    <tr>
                        <th scope="col" class="px-4 py-3">Título</th>
                        <th scope="col" class="px-4 py-3">Categoría</th>
                        <th scope="col" class="px-4 py-3">Fecha</th>
                        <th scope="col" class="px-4 py-3">Estado</th>
                        <th scope="col" class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($noticias as $noticia)
                        <tr>
                            <td class="px-4 py-3 font-semibold text-slate-800">{{ $noticia->titulo }}</td>
                            <td class="px-4 py-3">{{ $noticia->categoria->nombre }}</td>
                            <td class="px-4 py-3">{{ $noticia->fecha_publicacion->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">{{ $noticia->publicado ? 'Publicada' : 'Borrador' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap items-center gap-3">
                                    <a href="{{ route('admin.noticias.edit', $noticia) }}" class="font-semibold text-teal-800 hover:underline">Editar</a>
                                    <form action="{{ route('admin.noticias.destroy', $noticia) }}" method="POST" onsubmit="return confirm('¿Eliminar esta noticia?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-semibold text-red-700 hover:underline">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-6 text-center text-slate-600">Todavía no hay noticias registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $noticias->links() }}
    </main>
@endsection
