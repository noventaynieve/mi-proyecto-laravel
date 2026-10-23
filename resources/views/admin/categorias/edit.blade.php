@extends('layouts.municipal')

@section('title', 'Editar categoría')

@section('content')
    <main class="mx-auto max-w-2xl space-y-6 px-4 py-8">
        <h1 class="text-3xl font-extrabold text-slate-900">Editar categoría</h1>
        @include('admin.categorias._form', [
            'action' => route('admin.categorias.update', $categoria),
            'method' => 'PUT',
            'categoria' => $categoria,
            'submitLabel' => 'Actualizar categoría',
        ])
    </main>
@endsection
