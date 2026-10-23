<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="space-y-5 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    @if ($errors->any())
        <div role="alert" class="rounded border border-red-200 bg-red-50 p-3 text-sm text-red-800">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div>
        <label for="titulo" class="mb-1 block text-sm font-semibold text-slate-700">Título</label>
        <input id="titulo" name="titulo" value="{{ old('titulo', $noticia?->titulo) }}" required maxlength="255" class="w-full rounded border border-gray-300 px-3 py-2 text-sm">
    </div>
    <div>
        <label for="categoria_id" class="mb-1 block text-sm font-semibold text-slate-700">Categoría</label>
        @if ($categorias->isEmpty())
            <p class="mb-2 text-sm text-amber-800">
                Primero debes <a href="{{ route('admin.categorias.create') }}" class="font-semibold underline">crear una categoría</a>.
            </p>
        @endif
        <select id="categoria_id" name="categoria_id" required class="w-full rounded border border-gray-300 bg-white px-3 py-2 text-sm">
            <option value="">Selecciona una categoría</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}" @selected((string) old('categoria_id', $noticia?->categoria_id) === (string) $categoria->id)>{{ $categoria->nombre }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="extracto" class="mb-1 block text-sm font-semibold text-slate-700">Extracto</label>
        <textarea id="extracto" name="extracto" required maxlength="500" rows="3" class="w-full rounded border border-gray-300 px-3 py-2 text-sm">{{ old('extracto', $noticia?->extracto) }}</textarea>
    </div>
    <div>
        <label for="contenido" class="mb-1 block text-sm font-semibold text-slate-700">Contenido</label>
        <textarea id="contenido" name="contenido" required rows="10" class="w-full rounded border border-gray-300 px-3 py-2 text-sm">{{ old('contenido', $noticia?->contenido) }}</textarea>
    </div>
    <div>
        <label for="imagen_portada" class="mb-1 block text-sm font-semibold text-slate-700">Imagen de portada (JPG, PNG o WebP, máximo 2 MB)</label>
        <input id="imagen_portada" name="imagen_portada" type="file" accept=".jpg,.jpeg,.png,.webp" class="w-full rounded border border-gray-300 bg-white px-3 py-2 text-sm">
        @if ($noticia?->imageUrl())
            <img src="{{ $noticia->imageUrl() }}" alt="" class="mt-3 h-32 rounded object-cover">
        @endif
    </div>
    <div>
        <label for="fecha_publicacion" class="mb-1 block text-sm font-semibold text-slate-700">Fecha de publicación</label>
        <input id="fecha_publicacion" name="fecha_publicacion" type="date" value="{{ old('fecha_publicacion', $noticia?->fecha_publicacion?->toDateString() ?? today()->toDateString()) }}" required class="w-full rounded border border-gray-300 px-3 py-2 text-sm">
    </div>
    <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
        <input type="checkbox" name="publicado" value="1" @checked((bool) old('publicado', $noticia?->publicado ?? true))>
        Publicar esta noticia
    </label>

    <div class="flex flex-wrap gap-3">
        <button type="submit" class="rounded bg-[#0b435b] px-5 py-2 text-sm font-semibold text-white hover:bg-[#083346]">{{ $submitLabel }}</button>
        <a href="{{ route('admin.noticias.index') }}" class="rounded border border-gray-300 px-5 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancelar</a>
    </div>
</form>
