@extends('layouts.municipal')

@section('title', 'Editar noticia')

@section('content')
    <main class="mx-auto max-w-3xl space-y-6 px-4 py-8">
        <h1 class="text-3xl font-extrabold text-slate-900">Editar noticia</h1>
        @include('admin.noticias._form', [
            'action' => route('admin.noticias.update', $noticia),
            'method' => 'PUT',
            'noticia' => $noticia,
            'categorias' => $categorias,
            'submitLabel' => 'Actualizar noticia',
        ])
    </main>
@endsection
