<?php

namespace App\Models;

use Database\Factories\NoticiaFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Noticia extends Model
{
    /** @use HasFactory<NoticiaFactory> */
    use HasFactory;

    protected $fillable = [
        'categoria_id',
        'user_id',
        'titulo',
        'slug',
        'extracto',
        'contenido',
        'imagen_portada',
        'publicado',
        'fecha_publicacion',
    ];

    /**
     * @return BelongsTo<Categoria, $this>
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    #[Scope]
    protected function published(Builder $query): Builder
    {
        return $query->where('publicado', true)
            ->whereDate('fecha_publicacion', '<=', today());
    }

    public function imageUrl(): ?string
    {
        if ($this->imagen_portada === null) {
            return null;
        }

        if (str_starts_with($this->imagen_portada, 'img/')) {
            return asset($this->imagen_portada);
        }

        return Storage::disk('public')->url($this->imagen_portada);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'publicado' => 'boolean',
            'fecha_publicacion' => 'date',
        ];
    }
}
