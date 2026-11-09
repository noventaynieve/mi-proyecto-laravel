<?php

use App\Http\Controllers\Admin\CategoriaController as AdminCategoriaController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NoticiaController as AdminNoticiaController;
use App\Http\Controllers\Admin\RegistroFormulariosAdminController;
use App\Http\Controllers\Auth\SessionController;
use App\Http\Controllers\NoticiaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

Route::get('/', [NoticiaController::class, 'home'])->name('home');

Route::get('/menu', [NoticiaController::class, 'home'])->name('menu');

Route::get('/noticias', [NoticiaController::class, 'index'])->name('noticias.index');
Route::get('/noticias/{noticia}', [NoticiaController::class, 'show'])->name('noticias.show');

Route::get('/ingresar', [SessionController::class, 'create'])->name('login');
Route::post('/ingresar', [SessionController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('login.store');
Route::post('/salir', [SessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:super_admin,editor_general,transparencia,admin_dif,catastro'])
    ->group(function (): void {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/registros-formularios', [RegistroFormulariosAdminController::class, 'index'])
            ->name('formularios.index');
        Route::patch('/registros-formularios/{solicitudFormulario}', [RegistroFormulariosAdminController::class, 'updateEstatus'])
            ->name('formularios.updateEstatus');

        Route::middleware('role:editor_general')->group(function (): void {
            Route::resource('noticias', AdminNoticiaController::class)->except('show');
            Route::resource('categorias', AdminCategoriaController::class)->except('show');
        });
    });

Route::view('/presidencia', 'presidencia')->name('presidencia');
Route::view('/accesibilidad', 'accesibilidad')->name('accesibilidad');
Route::view('/ubicacion', 'ubicacion')->name('ubicacion');
Route::get('/convocatorias', function () {
    $publication = [
        'path' => 'pdf/convocatoria-la-casa-que-canta.pdf',
        'title' => 'convocatoria la casa que canta',
    ];

    return view('conv', [
        'publication' => [
            ...$publication,
            'available' => is_file(public_path($publication['path'])),
            'url' => asset($publication['path']),
        ],
    ]);
})->name('convocatorias');
Route::get('/reglamentos', function () {
    $regulation = [
        'path' => 'pdf/reglamentos/REGLAMENTO-SIPINNA-COCULA.pdf',
        'title' => 'Reglamento del Sistema Municipal de Protección Integral de Niñas, Niños y Adolescentes de Cocula (SIPINNA)',
        'category' => 'Protección integral de niñas, niños y adolescentes',
        'description' => 'Consulta el reglamento municipal que establece las bases para garantizar la protección integral de niñas, niños y adolescentes en Cocula.',
    ];

    return view('reglamentos', [
        'regulation' => [
            ...$regulation,
            'available' => is_file(public_path($regulation['path'])),
            'url' => asset($regulation['path']),
        ],
    ]);
})->name('reglamentos.index');
Route::view('/transparencia', 'transparencia')->name('transparencia');
Route::view('/info', 'info')->name('info');
Route::view('/tramites', 'tramites')->name('tramites');
Route::get('/tramites-inicio', function () {
    return redirect()->route('tramites');
})->name('tramites.index');
Route::view('/regidores', 'regidores')->name('regidores');
Route::view('/presidencia/regidores', 'regidores')->name('presidencia.regidores');
Route::view('/dif', 'dif')->name('dif');

Route::match(['get', 'post'], '/tramites/predial', function (Request $request) {
    if ($request->isMethod('post')) {
        $data = $request->validate([
            'cuenta' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:100'],
        ]);

        return back()->with('status', 'Consulta exitosa para la cuenta: '.$data['cuenta'].'. En este entorno de demostración, su cuenta no presenta adeudos pendientes.');
    }

    return view('predial');
})->name('tramites.predial');

Route::get('/gaceta', function () {
    $publications = [
        [
            'path' => 'pdf/gaceta/Gaceta-09-sep-2026-Informe-segundo-ano-de-gobierno-1.pdf',
            'title' => 'Gaceta 09 – sep 2026 – Informe segundo año de gobierno',
        ],
        [
            'path' => 'pdf/gaceta/gaceta8-agosto.pdf',
            'title' => 'Gaceta 08 – agosto 2026 – Hacienda, Infraestructura Hidráulica y Acciones Municipales',
        ],
    ];

    return view('gaceta', [
        'publications' => collect($publications)
            ->map(fn (array $publication): array => [
                ...$publication,
                'available' => is_file(public_path($publication['path'])),
                'url' => asset($publication['path']),
            ]),
    ]);
})->name('gaceta');
Route::view('/gaceta/ediciones', 'gaceta-placeholder', [
    'title' => 'Ediciones Anteriores',
    'message' => 'Las ediciones anteriores de la Gaceta Municipal estarán disponibles cuando se publiquen en este portal.',
])->name('gaceta.ediciones');
Route::view('/gaceta/actas', 'gaceta-placeholder', [
    'title' => 'Actas de Cabildo',
    'message' => 'Las actas de Cabildo estarán disponibles cuando se publiquen en este portal.',
])->name('gaceta.actas');
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
        ['title' => 'Reglamentos Municipales', 'description' => 'Consulta la normatividad municipal vigente.', 'url' => route('reglamentos.index')],
        ['title' => 'Gaceta Municipal', 'description' => 'Acuerdos, reglamentos y publicaciones oficiales.', 'url' => route('gaceta')],
        ['title' => 'Transparencia y SEVAC', 'description' => 'Obligaciones comunes, información financiera y rendición de cuentas.', 'url' => route('transparencia')],
        ['title' => 'Comité de Pueblo Mágico', 'description' => 'Conoce la integración y los integrantes del Comité de Pueblo Mágico de Cocula.', 'url' => route('info')],
        ['title' => 'DIF Municipal', 'description' => 'Conoce a la presidenta del DIF Municipal de Cocula y su mensaje a la ciudadanía.', 'url' => route('dif')],
        ['title' => 'Trámites y Servicios', 'description' => 'Pago de predial, licencias municipales y agua potable.', 'url' => route('tramites')],
        ['title' => 'Pago de Agua y Predial', 'description' => 'Consulta los requisitos e información para realizar pagos en línea.', 'url' => route('tramites')],
        ['title' => 'Consulta de Predial (demostración)', 'description' => 'Prueba el formulario de consulta de predial; no realiza pagos reales.', 'url' => route('tramites.predial')],
        ['title' => 'Solicitud de Licencia Comercial (demostración)', 'description' => 'Revisa los campos y requisitos del formulario de licencia comercial.', 'url' => route('solicitud-licencia')],
        ['title' => 'Solicitud de Información Pública', 'description' => 'Consulta el formulario de demostración para solicitar información pública.', 'url' => route('solicitud-transparencia')],
        ['title' => 'Atención Ciudadana', 'description' => 'Información para reportes de servicios públicos.', 'url' => route('atencion-ciudadana')],
        ['title' => 'Accesibilidad', 'description' => 'Programas y gestiones de accesibilidad del Gobierno de Cocula.', 'url' => route('accesibilidad')],
        ['title' => 'Ubicación', 'description' => 'Mapa de referencia del centro de Cocula, Jalisco.', 'url' => route('ubicacion')],
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
