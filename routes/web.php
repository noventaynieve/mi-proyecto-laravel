<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('menu');
})->name('home');

Route::get('/menu', function () {
    return view('menu');
})->name('menu');

Route::view('/presidencia', 'presidencia')->name('presidencia');
Route::view('/transparencia', 'transparencia')->name('transparencia');
Route::view('/tramites', 'tramites')->name('tramites');
Route::view('/regidores', 'regidores')->name('regidores');
Route::view('/gaceta', 'gaceta')->name('gaceta');
Route::view('/atencion-ciudadana', 'atencion-ciudadana')->name('atencion-ciudadana');
Route::view('/solicitud-transparencia', 'solicitud-transparencia')->name('solicitud-transparencia');
Route::view('/solicitud-licencia', 'solicitud-licencia')->name('solicitud-licencia');

Route::get('/buscar', function (Request $request) {
    $validated = $request->validate([
        'q' => ['nullable', 'string', 'max:100'],
    ]);
    $query = trim($validated['q'] ?? '');

    $sections = [
        ['title' => 'Inicio', 'description' => 'Noticias y avisos oficiales del Gobierno Municipal.', 'url' => route('home')],
        ['title' => 'Presidencia Municipal', 'description' => 'Directorio de funcionarios y datos de contacto.', 'url' => route('presidencia')],
        ['title' => 'Regidores y Cabildo', 'description' => 'Integrantes y comisiones del Ayuntamiento.', 'url' => route('regidores')],
        ['title' => 'Gaceta Municipal', 'description' => 'Acuerdos, reglamentos y publicaciones oficiales.', 'url' => route('gaceta')],
        ['title' => 'Transparencia y SEVAC', 'description' => 'Obligaciones comunes, información financiera y rendición de cuentas.', 'url' => route('transparencia')],
        ['title' => 'Trámites y Servicios', 'description' => 'Pago de predial, licencias municipales y agua potable.', 'url' => route('tramites')],
        ['title' => 'Atención Ciudadana', 'description' => 'Información para reportes de servicios públicos.', 'url' => route('atencion-ciudadana')],
    ];

    $results = $query === ''
        ? collect()
        : collect($sections)->filter(fn (array $section): bool => Str::contains(
            Str::lower($section['title'].' '.$section['description']),
            Str::lower($query),
        ));

    return view('buscar', compact('query', 'results'));
})->name('buscar');

Route::get('/saludo/{nombre}', function ($nombre) {
    return '¡Hola, '.$nombre.'! Este es un mensaje personalizado desde tu proyecto de Laravel.';
});

Route::get('/contacto/{nombre?}', function ($nombre = 'Usuario') {
    return view('contacto', ['nombre' => $nombre]);
})->name('contacto');
