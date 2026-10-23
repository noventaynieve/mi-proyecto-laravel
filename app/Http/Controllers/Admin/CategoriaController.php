<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoriaController extends Controller
{
    public function index(): View
    {
        return view('admin.categorias.index', [
            'categorias' => Categoria::query()
                ->withCount('noticias')
                ->orderBy('nombre')
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.categorias.create');
    }

    public function store(StoreCategoriaRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Categoria::create([
            ...$validated,
            'slug' => $this->uniqueSlug($validated['nombre']),
        ]);

        return redirect()
            ->route('admin.categorias.index')
            ->with('status', 'La categoría se creó correctamente.');
    }

    public function edit(Categoria $categoria): View
    {
        return view('admin.categorias.edit', [
            'categoria' => $categoria,
        ]);
    }

    public function update(UpdateCategoriaRequest $request, Categoria $categoria): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = $this->uniqueSlug($validated['nombre'], $categoria);
        $categoria->update($validated);

        return redirect()
            ->route('admin.categorias.index')
            ->with('status', 'La categoría se actualizó correctamente.');
    }

    public function destroy(Categoria $categoria): RedirectResponse
    {
        $categoria->delete();

        return redirect()
            ->route('admin.categorias.index')
            ->with('status', 'La categoría y sus noticias asociadas se eliminaron.');
    }

    private function uniqueSlug(string $title, ?Categoria $categoria = null): string
    {
        $baseSlug = Str::slug($title) ?: 'categoria';
        $slug = $baseSlug;
        $suffix = 2;

        while (Categoria::query()
            ->where('slug', $slug)
            ->when($categoria, fn ($query) => $query->where('id', '!=', $categoria->id))
            ->exists()) {
            $slug = $baseSlug.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }
}
