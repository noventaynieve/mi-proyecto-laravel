@extends('layouts.municipal')

@section('title', 'Crear categoría')

@section('content')
    <main class="mx-auto max-w-2xl space-y-6 px-4 py-8">
        <h1 class="text-3xl font-extrabold text-slate-900">Crear categoría</h1>
        @include('admin.categorias._form', [
            'action' => route('admin.categorias.store'),
            'method' => 'POST',
            'categoria' => null,
            'submitLabel' => 'Guardar categoría',
        ])
    </main>
@endsection
