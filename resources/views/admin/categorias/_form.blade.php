<form action="{{ $action }}" method="POST" class="space-y-5 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
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
        <label for="nombre" class="mb-1 block text-sm font-semibold text-slate-700">Nombre</label>
        <input id="nombre" name="nombre" value="{{ old('nombre', $categoria?->nombre) }}" required maxlength="255" class="w-full rounded border border-gray-300 px-3 py-2 text-sm">
    </div>
    <div>
        <label for="descripcion" class="mb-1 block text-sm font-semibold text-slate-700">Descripción (opcional)</label>
        <textarea id="descripcion" name="descripcion" maxlength="1000" rows="4" class="w-full rounded border border-gray-300 px-3 py-2 text-sm">{{ old('descripcion', $categoria?->descripcion) }}</textarea>
    </div>
    <div class="flex flex-wrap gap-3">
        <button type="submit" class="rounded bg-[#0b435b] px-5 py-2 text-sm font-semibold text-white hover:bg-[#083346]">{{ $submitLabel }}</button>
        <a href="{{ route('admin.categorias.index') }}" class="rounded border border-gray-300 px-5 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancelar</a>
    </div>
</form>
