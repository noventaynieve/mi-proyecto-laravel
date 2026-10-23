<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNoticiaRequest;
use App\Http\Requests\UpdateNoticiaRequest;
use App\Models\Categoria;
use App\Models\Noticia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NoticiaController extends Controller
{
    public function index(): View
    {
        return view('admin.noticias.index', [
            'noticias' => Noticia::query()
                ->with(['categoria', 'autor'])
                ->latest('fecha_publicacion')
                ->latest('id')
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.noticias.create', [
            'categorias' => Categoria::query()->orderBy('nombre')->get(),
        ]);
    }

    public function store(StoreNoticiaRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $image = $validated['imagen_portada'] ?? null;
        unset($validated['imagen_portada']);

        Noticia::create([
            ...$validated,
            'slug' => $this->uniqueSlug($validated['titulo']),
            'user_id' => $request->user()->id,
            'imagen_portada' => $image?->store('noticias', 'public'),
            'publicado' => (bool) ($validated['publicado'] ?? false),
        ]);

        return redirect()
            ->route('admin.noticias.index')
            ->with('status', 'La noticia se creó correctamente.');
    }

    public function edit(Noticia $noticia): View
    {
        return view('admin.noticias.edit', [
            'noticia' => $noticia,
            'categorias' => Categoria::query()->orderBy('nombre')->get(),
        ]);
    }

    public function update(UpdateNoticiaRequest $request, Noticia $noticia): RedirectResponse
    {
        $validated = $request->validated();
        $image = $validated['imagen_portada'] ?? null;
        unset($validated['imagen_portada']);

        $validated['slug'] = $this->uniqueSlug($validated['titulo'], $noticia);
        $validated['publicado'] = (bool) ($validated['publicado'] ?? false);

        if ($image !== null) {
            if ($noticia->imagen_portada !== null) {
                Storage::disk('public')->delete($noticia->imagen_portada);
            }

            $validated['imagen_portada'] = $image->store('noticias', 'public');
        }

        $noticia->update($validated);

        return redirect()
            ->route('admin.noticias.index')
            ->with('status', 'La noticia se actualizó correctamente.');
    }

    public function destroy(Noticia $noticia): RedirectResponse
    {
        if ($noticia->imagen_portada !== null) {
            Storage::disk('public')->delete($noticia->imagen_portada);
        }

        $noticia->delete();

        return redirect()
            ->route('admin.noticias.index')
            ->with('status', 'La noticia se eliminó correctamente.');
    }

    private function uniqueSlug(string $title, ?Noticia $noticia = null): string
    {
        $baseSlug = Str::slug($title) ?: 'noticia';
        $slug = $baseSlug;
        $suffix = 2;

        while (Noticia::query()
            ->where('slug', $slug)
            ->when($noticia, fn ($query) => $query->where('id', '!=', $noticia->id))
            ->exists()) {
            $slug = $baseSlug.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }
}
