<?php

namespace Database\Seeders;

use App\Models\SolicitudFormulario;
use Illuminate\Database\Seeder;

class SolicitudFormularioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SolicitudFormulario::factory()->count(15)->create();
    }
}
