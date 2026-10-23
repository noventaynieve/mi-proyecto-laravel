<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoticiaController extends Controller
{
    public function home(): View
    {
        return view('menu', [
            'noticias' => Noticia::published()
                ->with('categoria')
                ->latest('fecha_publicacion')
                ->latest('id')
                ->limit(3)
                ->get(),
        ]);
    }

    public function index(Request $request): View
    {
        $filters = $request->validate([
            'buscar' => ['nullable', 'string', 'max:100'],
            'categoria' => ['nullable', 'string', 'exists:categorias,slug'],
        ]);

        $noticias = Noticia::published()
            ->with('categoria')
            ->when($filters['buscar'] ?? null, function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('titulo', 'like', '%'.$search.'%')
                        ->orWhere('extracto', 'like', '%'.$search.'%')
                        ->orWhere('contenido', 'like', '%'.$search.'%');
                });
            })
            ->when($filters['categoria'] ?? null, function ($query, string $slug): void {
                $query->whereHas('categoria', fn ($query) => $query->where('slug', $slug));
            })
            ->latest('fecha_publicacion')
            ->latest('id')
            ->paginate(6)
            ->withQueryString();

        return view('noticias.index', [
            'noticias' => $noticias,
            'categorias' => Categoria::query()->orderBy('nombre')->get(),
            'filters' => $filters,
        ]);
    }

    public function show(Noticia $noticia): View
    {
        abort_unless(
            $noticia->publicado && $noticia->fecha_publicacion->lte(today()),
            404,
        );

        return view('noticias.show', [
            'noticia' => $noticia->load(['categoria', 'autor']),
        ]);
    }
}
