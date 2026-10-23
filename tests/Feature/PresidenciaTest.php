<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PresidenciaTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_gaceta_navigation_has_dropdown_links_for_each_section(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSeeInOrder([
            '<a href="'.route('gaceta').'"',
            '>Gaceta</a>',
            '<button id="dropdown-gaceta-btn"',
            '<a href="'.route('gaceta').'" class="block px-4 py-2.5 text-sm font-semibold hover:bg-cyan-50 hover:text-cyan-900">Gaceta Municipal</a>',
            '<a href="'.route('gaceta.ediciones').'"',
            '<a href="'.route('gaceta.actas').'"',
        ], false);
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
