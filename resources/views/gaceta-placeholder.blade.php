@extends('layouts.municipal')

@section('title', $title.' - Gaceta Municipal')

@section('content')
    <main class="mx-auto max-w-5xl px-4 py-8">
        <section class="space-y-4 rounded-lg border border-gray-200 bg-white p-6 shadow-sm sm:p-10">
            <h1 class="border-b border-gray-200 pb-4 text-3xl font-bold uppercase tracking-tight text-slate-900">{{ $title }}</h1>
            <p class="text-sm leading-relaxed text-slate-600">{{ $message }}</p>
            <a href="{{ route('gaceta') }}" class="inline-block text-sm font-semibold text-[#0b435b] underline hover:text-slate-900">
                Volver a la Gaceta Municipal
            </a>
        </section>
    </main>
@endsection
