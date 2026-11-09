<?php

namespace Database\Factories;

use App\Models\SolicitudFormulario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SolicitudFormulario>
 */
class SolicitudFormularioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $moduloOrigen = fake()->randomElement(SolicitudFormulario::MODULOS_ORIGEN);

        return [
            'folio' => 'SOL-'.now()->year.'-'.fake()->unique()->numerify('######'),
            'modulo_origen' => $moduloOrigen,
            'nombre_completo' => fake()->name(),
            'email' => fake()->safeEmail(),
            'telefono' => fake()->optional()->numerify('375#######'),
            'curp' => null,
            'asunto' => fake()->sentence(4),
            'mensaje_solicitud' => fake()->paragraph(),
            'estatus' => fake()->randomElement(SolicitudFormulario::ESTATUS),
            'observaciones_internas' => null,
        ];
    }
}
