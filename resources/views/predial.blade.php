@extends('layouts.app')

@section('title', 'Consulta y Pago de Impuesto Predial - Gobierno de Cocula')

@section('content')
<main class="max-w-4xl mx-auto px-4 py-12">
    
    <div class="bg-white p-8 sm:p-12 rounded-lg border border-gray-200 shadow-sm text-center space-y-8">
        
        <!-- Encabezado de la entidad -->
        <div class="text-xs sm:text-sm font-semibold text-slate-700 tracking-wider uppercase space-y-1">
            <p>CENTRO CP: 48500</p>
            <p>MUNICIPIO DE COCULA JALISCO, JALISCO</p>
        </div>

        <!-- Logotipo Impuesto Predial -->
        <div class="flex flex-col items-center justify-center space-y-2">
            <div class="w-24 h-24 text-[#9ebd83] flex items-center justify-center">
                <!-- Icono de Casa con Moneda de Predial -->
                <svg xmlns="http://www.w3.org/2000/svg" class="w-20 h-20 fill-current" viewBox="0 0 24 24">
                    <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-[#8fae73] uppercase tracking-wide">
                Impuesto Predial
            </h2>
        </div>

        @if (session('status'))
            <div class="p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm font-semibold text-center">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm text-left">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulario de Consulta -->
        <form action="{{ route('tramites.predial') }}" method="POST" class="max-w-xl mx-auto space-y-6 text-left">
            @csrf

            <!-- Campo Cuenta -->
            <div class="space-y-1">
                <div class="relative">
                    <input 
                        type="text" 
                        name="cuenta" 
                        id="cuenta" 
                        required
                        value="{{ old('cuenta') }}"
                        placeholder="Cuenta"
                        class="w-full px-4 py-3 border border-gray-400 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-slate-800 placeholder-slate-500"
                    >
                </div>
                <p class="text-xs text-slate-500 pl-1">
                    Ejemplo: R000000 o U000000 (Tal como se indica en la IMAGEN 2 de tu recibo)
                </p>
            </div>

            <!-- Campo Correo Electrónico -->
            <div class="space-y-1">
                <div class="relative">
                    <label for="email" class="absolute -top-2.5 left-3 bg-white px-1 text-xs text-blue-600 font-medium">
                        Correo
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        required
                        value="{{ old('email') }}"
                        placeholder="Correo Electrónico"
                        class="w-full px-4 py-3 border-2 border-blue-500 rounded-md focus:ring-2 focus:ring-blue-600 outline-none transition-all text-slate-800"
                    >
                </div>
                <p class="text-xs text-slate-500 pl-1">
                    Correo Electrónico (Aquí recibirás tu recibo oficial tras realizar el pago)
                </p>
            </div>

            <!-- Botón Consultar -->
            <div class="pt-4">
                <button 
                    type="submit" 
                    class="w-full bg-[#adca8c] hover:bg-[#9ebd83] text-white font-bold py-3.5 px-6 rounded-lg shadow transition-colors duration-200 flex items-center justify-center space-x-2 text-base uppercase tracking-wider"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>CONSULTAR</span>
                </button>
            </div>

        </form>

        <!-- Botón para Regresar -->
        <div class="pt-4">
            <a href="{{ route('tramites') }}" class="text-xs text-slate-500 hover:text-slate-800 underline">
                &larr; Volver a la sección de trámites e instrucciones
            </a>
        </div>

    </div>

</main>
@endsection
