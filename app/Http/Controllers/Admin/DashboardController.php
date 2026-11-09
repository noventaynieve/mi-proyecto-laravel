<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $usuariosActivos = User::query()
            ->where('activo', true)
            ->whereIn('role', User::PANEL_ROLES)
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->get();

        return view('admin.dashboard', [
            'stats' => [
                'total_noticias' => Noticia::published()->count(),
                'total_usuarios' => $usuariosActivos->count(),
            ],
            'usuariosActivos' => $usuariosActivos,
            'ultimasNoticias' => Noticia::query()
                ->with('categoria')
                ->latest('fecha_publicacion')
                ->latest('id')
                ->limit(5)
                ->get(),
        ]);
    }
}
