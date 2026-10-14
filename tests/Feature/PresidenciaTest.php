<?php

namespace Tests\Feature;

use Tests\TestCase;

class PresidenciaTest extends TestCase
{
    public function test_homepage_menu_links_to_presidencia_page(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSeeInOrder([
            '<a href="'.route('presidencia').'"',
            '>PRESIDENCIA</a>',
            '<button id="dropdown-presidencia-btn"',
        ], false);
        $response->assertSee('bg-gobierno-navy', false);
        $response->assertSeeInOrder(['>PAGO</span>', '>DE SERV</span>'], false);
    }

    public function test_presidencia_page_renders_directory_filter_and_president_information(): void
    {
        $response = $this->get('/presidencia');

        $response->assertOk();
        $response->assertSee('Directorio de Funcionarios');
        $response->assertSee('select-dependencia', false);
        $response->assertSee('data-dependencia="general"', false);
        $response->assertSee('data-dependencia="hacienda"', false);
        $response->assertSee('data-dependencia="obras"', false);
        $response->assertSee('Luis Armando Aldana González');
        $response->assertSee('presidencia@cocula.gob.mx');
    }

    public function test_presidencia_page_has_a_link_back_to_homepage(): void
    {
        $response = $this->get('/presidencia');

        $response->assertOk();
        $response->assertSeeInOrder([
            '<a href="'.url('/').'"',
            '>Inicio</a>',
        ], false);
    }
}
