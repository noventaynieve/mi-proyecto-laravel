<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Noticia;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Noticia>
 */
class NoticiaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titulo = fake()->unique()->sentence();

        return [
            'categoria_id' => Categoria::factory(),
            'user_id' => User::factory(),
            'titulo' => $titulo,
            'slug' => Str::slug($titulo),
            'extracto' => fake()->paragraph(),
            'contenido' => fake()->paragraphs(3, true),
            'imagen_portada' => null,
            'publicado' => true,
            'fecha_publicacion' => today(),
        ];
    }

    public function unpublished(): static
    {
        return $this->state(fn (array $attributes): array => [
            'publicado' => false,
        ]);
    }
}
