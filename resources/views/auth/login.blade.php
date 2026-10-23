@extends('layouts.municipal')

@section('title', 'Acceso administrativo')

@section('content')
    <main class="mx-auto max-w-lg px-4 py-12">
        <section class="space-y-6 rounded-lg border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <header class="space-y-2">
                <h1 class="text-2xl font-bold text-slate-900">Acceso administrativo</h1>
                <p class="text-sm text-slate-600">Inicia sesión con una cuenta administradora para gestionar noticias y categorías.</p>
            </header>

            @if ($errors->any())
                <div role="alert" class="rounded border border-red-200 bg-red-50 p-3 text-sm text-red-800">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('login.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-1 block text-sm font-semibold text-slate-700">Correo electrónico</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="username" required autofocus class="w-full rounded border border-gray-300 px-3 py-2 text-sm">
                </div>
                <div>
                    <label for="password" class="mb-1 block text-sm font-semibold text-slate-700">Contraseña</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required class="w-full rounded border border-gray-300 px-3 py-2 text-sm">
                </div>
                <button type="submit" class="w-full rounded bg-[#0b435b] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#083346]">Iniciar sesión</button>
            </form>
        </section>
    </main>
@endsection
