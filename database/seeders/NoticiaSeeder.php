<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Noticia;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NoticiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Categoria::firstOrCreate(
            ['slug' => 'sistemas'],
            [
                'nombre' => 'Sistemas y Salud',
                'descripcion' => 'Comunicados de sistemas, salud pública y prevención.',
            ],
        );

        $author = User::firstOrCreate(
            ['email' => 'contenido@cocula.gob.mx'],
            [
                'name' => 'Portal de Cocula',
                'password' => Str::random(64),
            ],
        );

        Noticia::firstOrCreate(
            ['slug' => 'dengue-comando-incidentes'],
            [
                'categoria_id' => $category->id,
                'user_id' => $author->id,
                'titulo' => 'Cocula reactiva el Sistema de Comando de Incidentes para reforzar las acciones de prevención y combate al dengue',
                'extracto' => 'Con el objetivo de fortalecer las estrategias de prevención, control y combate al dengue, el Ayuntamiento reactivó el Sistema de Comando de Incidentes.',
                'contenido' => <<<'TEXT'
Cocula, Jalisco.— Con el objetivo de fortalecer las estrategias de prevención, control y combate al dengue, el presidente municipal de Cocula, Lic. Luis Aldana, instruyó la reactivación del Sistema de Comando de Incidentes, mecanismo que permite coordinar y reforzar las acciones entre las distintas instancias de gobierno y el sector salud.

Ante la presencia de casos de dengue en el municipio, se mantiene el trabajo conjunto entre representantes del ámbito nacional y estatal, la Región Sanitaria IX, el Ayuntamiento de Cocula y la microrregión Cocula, con el propósito de sumar esfuerzos para contener la propagación del mosquito transmisor y proteger la salud de la población.

Aunque las acciones preventivas se han desarrollado de manera permanente, esta nueva activación permitirá intensificar los trabajos de control y vigilancia, así como fortalecer las estrategias de concientización dirigidas a la ciudadanía, considerada una parte fundamental en la prevención de esta enfermedad.

Entre las medidas que se impulsan se encuentra la eliminación de criaderos, la identificación de espacios donde pueda acumularse agua y la implementación del pez Guppy como una estrategia complementaria para el control de las larvas del mosquito en determinados depósitos de agua, bajo las indicaciones de las autoridades sanitarias.

El Gobierno Municipal destacó que la participación de las familias es indispensable para lograr resultados, por lo que hizo un llamado a la población a mantener patios, azoteas y espacios comunes limpios, voltear recipientes que puedan acumular agua, lavar depósitos y eliminar objetos en desuso que favorezcan la reproducción del mosquito.

Asimismo, se invita a la ciudadanía a brindar las facilidades necesarias a las brigadas de salud debidamente identificadas, que realizan labores de prevención, orientación y control en el municipio.

El presidente municipal, Luis Aldana, refrenda así su compromiso de mantener la coordinación institucional y fortalecer las acciones que contribuyan al cuidado de la salud pública, priorizando la prevención y la participación comunitaria.

La lucha contra el dengue es una responsabilidad compartida. Con trabajo coordinado entre autoridades y ciudadanía, Cocula continúa reforzando las medidas para reducir los riesgos de transmisión y proteger el bienestar de las familias.

¡Cocula, en lucha contra el dengue!
TEXT,
                'imagen_portada' => 'img/WhatsApp-Image-2026-10-12-at-6.34.06-PM.jpeg',
                'publicado' => true,
                'fecha_publicacion' => '2026-10-13',
            ],
        );
    }
}
