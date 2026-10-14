<?php

namespace Tests\Feature;

use Tests\TestCase;

class MunicipalSectionsTest extends TestCase
{
    public function test_homepage_links_to_transparency_and_services_pages(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('href="'.route('transparencia').'"', false);
        $response->assertSee('href="'.route('tramites').'"', false);
    }

    public function test_municipal_pages_share_the_header_navigation_and_footer(): void
    {
        foreach ([
            '/',
            route('presidencia'),
            route('regidores'),
            route('gaceta'),
            route('transparencia'),
            route('tramites'),
            route('atencion-ciudadana'),
        ] as $url) {
            $response = $this->get($url);

            $response->assertOk();
            $response->assertSee('Bienvenidos a la página oficial de');
            $response->assertSee('H. Ayuntamiento de Cocula');
            $response->assertSee('href="'.url('/').'"', false);
        }
    }

    public function test_homepage_links_to_highlighted_municipal_sections(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('href="'.route('atencion-ciudadana').'"', false);
        $response->assertSee('href="'.route('gaceta').'"', false);
        $response->assertSee('href="'.route('regidores').'"', false);
    }

    public function test_transparency_page_renders_transparency_obligations_table(): void
    {
        $response = $this->get(route('transparencia'));

        $response->assertOk();
        $response->assertSee('Portal de Transparencia y SEVAC');
        $response->assertSee('Obligaciones comunes');
        $response->assertSee('Remuneración bruta y neta de funcionarios');
        $response->assertSee('Presupuesto asignado e informes SEVAC');
        $response->assertSee('Documento pendiente de publicación');
        $response->assertSee('>Inicio</a>', false);
    }

    public function test_services_page_renders_available_municipal_services(): void
    {
        $response = $this->get(route('tramites'));

        $response->assertOk();
        $response->assertSee('Pago de Servicios y Trámites Municipales');
        $response->assertSee('Pago de Predial');
        $response->assertSee('Licencias Municipales');
        $response->assertSee('Agua Potable y Servicios');
        $response->assertSee('Los enlaces de pago y consulta se activarán');
        $response->assertSee('disabled', false);
        $response->assertSee('>Inicio</a>', false);
    }

    public function test_council_page_does_not_publish_unverified_member_details(): void
    {
        $response = $this->get(route('regidores'));

        $response->assertOk();
        $response->assertSee('Integrantes del H. Ayuntamiento');
        $response->assertSee('pendientes de validación oficial');
        $response->assertDontSee('Lic. Juan Pérez Gómez');
    }

    public function test_gazette_page_does_not_link_to_nonexistent_documents(): void
    {
        $response = $this->get(route('gaceta'));

        $response->assertOk();
        $response->assertSee('Gaceta Municipal');
        $response->assertSee('Las publicaciones oficiales se incorporarán');
        $response->assertDontSee('Descargar PDF');
    }

    public function test_citizen_attention_page_explains_that_reports_are_not_received(): void
    {
        $response = $this->get(route('atencion-ciudadana'));

        $response->assertOk();
        $response->assertSee('Atención Ciudadana y Reportes');
        $response->assertSee('todavía no recibe ni almacena reportes ciudadanos');
        $response->assertSee('contacto@cocula.gob.mx');
        $response->assertDontSee('Enviar Reporte');
    }

    public function test_search_returns_relevant_section_and_escapes_query(): void
    {
        $response = $this->get(route('buscar', ['q' => '<script>']));

        $response->assertOk();
        $response->assertSee('<script>');
        $response->assertDontSee('<script>', false);
        $response->assertSee('No se encontraron secciones');
    }

    public function test_search_returns_matching_gazette_page(): void
    {
        $response = $this->get(route('buscar', ['q' => 'Gaceta']));

        $response->assertOk();
        $response->assertSee('Gaceta Municipal');
        $response->assertSee('href="'.route('gaceta').'"', false);
    }

    public function test_search_rejects_queries_longer_than_one_hundred_characters(): void
    {
        $response = $this->get(route('buscar', ['q' => str_repeat('a', 101)]));

        $response->assertRedirect();
        $response->assertSessionHasErrors('q');
    }
}
