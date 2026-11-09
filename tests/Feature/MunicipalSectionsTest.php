<?php

namespace Tests\Feature;

use App\Models\Noticia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MunicipalSectionsTest extends TestCase
{
    use RefreshDatabase;

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
            route('presidencia.regidores'),
            route('reglamentos.index'),
            route('convocatorias'),
            route('gaceta'),
            route('accesibilidad'),
            route('ubicacion'),
            route('transparencia'),
            route('dif'),
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

    public function test_public_and_admin_layouts_render_the_shared_cocula_brand(): void
    {
        $admin = User::factory()->admin()->create();

        $publicResponse = $this->get(route('home'));
        $adminResponse = $this->actingAs($admin)->get(route('admin.dashboard'));

        foreach ([$publicResponse, $adminResponse] as $response) {
            $response->assertOk();
            $response->assertSee('src="'.asset('img/cropped-logo2025.webp').'"', false);
            $response->assertSee('alt="Escudo del Gobierno de Cocula"', false);
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

    public function test_info_page_is_reachable_from_navigation_and_shows_magic_town_committee_information(): void
    {
        $homepage = $this->get(route('home'));
        $response = $this->get(route('info'));

        $homepage->assertOk();
        $homepage->assertSee('href="'.route('info').'"', false);
        $response->assertOk();
        $response->assertSee('Comité de Pueblo Mágico');
        $response->assertSee('viernes 28 de febrero de 2025');
        $response->assertSee('Hasta cuatro Vocalías Ciudadanas');
        $response->assertSeeInOrder([
            'LUIS ARMANDO ALDANA GONZALEZ',
            'JUAN MANUEL SEVILLA GONZALEZ',
            'MARIA CRISTINA RAMIREZ BARRAZA',
            'AURORA YURIDIA VALADEZ PLAZOLA',
            'DOLORES CATALINA IBARRA CORTEZ',
            'MARIA LUISA GABRIELA RAMIREZ OLIVA',
            'VICTOR HUGO MONTES BARBOZA',
            'LANCELOT NANDINO GUTIERREZ',
            'LUIS ALBERTO RAMIREZ BARRAZA',
            'JOSE RAFAEL RUBIO IBARRA',
            'CARLOS ALBERTO ACOSTA GALLEGOS',
            'DIEGO MIGUEL GARCIA HERNANDEZ',
            'MIGUEL RAFAEL FLETES PALACIOS',
        ]);
    }

    public function test_dif_page_is_reachable_from_navigation_and_shows_the_presidents_message(): void
    {
        $homepage = $this->get(route('home'));
        $response = $this->get(route('dif'));

        $homepage->assertOk();
        $homepage->assertSee('href="'.route('dif').'"', false);
        $response->assertOk();
        $response->assertSee('Belia Alicia Flores Ramos');
        $response->assertSee('Presidenta del DIF Municipal de Cocula');
        $response->assertSee('fortalecimiento de nuestros programas sociales');
        $response->assertSee('Luis Armando Aldana González');
        $response->assertSee('Fotografía pendiente de publicación.');
        $response->assertDontSee('ruta/a/la/foto_directora.jpg');
    }

    public function test_accessibility_page_renders_from_navigation_with_programs_and_recent_notes(): void
    {
        $homepage = $this->get(route('home'));
        $response = $this->get(route('accesibilidad'));
        $search = $this->get(route('buscar', ['q' => 'Accesibilidad']));

        $homepage->assertOk();
        $homepage->assertSee('href="'.route('accesibilidad').'"', false);

        $response->assertOk();
        $response->assertSee('Programa de accesibilidad');
        $response->assertSee('Gestiones ante el CRIT de Occidente');
        $response->assertSee('Oro para Cocula en los CONADE');
        $response->assertSee('Cocula reconoce participación en los CONADE 2021');
        $response->assertSee('Enlace pendiente de publicación');
        $response->assertSeeInOrder([
            'Reconocen a tres coculenses con los Distintivos al Compromiso Comunitario',
            'Gobierno de Cocula anuncia nuevo programa de rehabilitación de calles con recursos municipales',
            'Cocula impulsa la prevención del cáncer de mama y cervicouterino con jornada de concientización',
            'Mariachi Sol de Mi Tierra obtiene el tercer lugar en concurso infantil y juvenil en Puerto Vallarta',
        ]);

        $search->assertOk();
        $search->assertSee('href="'.route('accesibilidad').'"', false);
    }

    public function test_location_page_renders_google_maps_embed_and_is_linked_from_the_portal(): void
    {
        config()->set('services.google_maps.key', null);

        $homepage = $this->get(route('home'));
        $response = $this->get(route('ubicacion'));

        $homepage->assertOk();
        $homepage->assertSee('href="'.route('ubicacion').'"', false);

        $response->assertOk();
        $response->assertSee('Explorador de Ubicaciones');
        $response->assertSee('Centro de Cocula, Jalisco');
        $response->assertSee('20.3667%2C-103.8167', false);
        $response->assertSee('title="Mapa de referencia del centro de Cocula, Jalisco"', false);
        $response->assertSee('loading="lazy"', false);
        $response->assertSee('href="https://www.google.com/maps/dir/?api=1&amp;destination=20.3667%2C-103.8167"', false);
        $response->assertSee('GOOGLE_MAPS_API_KEY', false);
        $response->assertDontSee('data-google-map', false);
        $response->assertDontSee('data-map-locate', false);
    }

    public function test_location_page_enables_interactive_google_maps_when_an_api_key_is_configured(): void
    {
        config()->set('services.google_maps.key', 'test-browser-key');

        $response = $this->get(route('ubicacion'));

        $response->assertOk();
        $response->assertSee('data-google-maps-api-key="test-browser-key"', false);
        $response->assertSee('data-place-autocomplete', false);
        $response->assertSee('data-map-locate', false);
        $response->assertSee('data-map-traffic', false);
        $response->assertDontSee('Configura GOOGLE_MAPS_API_KEY');
    }

    public function test_homepage_renders_recent_news_and_links_to_its_detail(): void
    {
        $noticia = Noticia::factory()->create([
            'titulo' => 'Cocula reactiva el Sistema de Comando de Incidentes para reforzar las acciones de prevención y combate al dengue',
            'imagen_portada' => 'img/WhatsApp-Image-2026-10-12-at-6.34.06-PM.jpeg',
            'extracto' => 'Cocula fortalece la prevención y el combate al dengue.',
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Noticias y Avisos Recientes');
        $response->assertSee('Sistema de Comando de Incidentes');
        $response->assertSee('src="'.asset('img/WhatsApp-Image-2026-10-12-at-6.34.06-PM.jpeg').'"', false);
        $response->assertSee('href="'.route('noticias.show', $noticia).'"', false);
        $response->assertSee('Cascada El Salto');
        $response->assertSee('Bienvenido al Gobierno Municipal de Cocula');
        $response->assertSee('Pago de Predial');
        $response->assertSee('Licencias');
        $response->assertSee('Avisos Importantes');
        $response->assertSee('Consulta rápida');
        $response->assertSee('Entradas del sitio');
        $response->assertSee('Archivos');
    }

    public function test_news_detail_page_renders_article_and_links_back_home(): void
    {
        $noticia = Noticia::factory()->create([
            'titulo' => 'Cocula reactiva el Sistema de Comando de Incidentes',
            'contenido' => 'La lucha contra el dengue es una responsabilidad compartida.',
        ]);
        $response = $this->get(route('noticias.show', $noticia));

        $response->assertOk();
        $response->assertSee('Cocula reactiva el Sistema de Comando de Incidentes');
        $response->assertSee('La lucha contra el dengue es una responsabilidad compartida');
        $response->assertSee('href="'.route('noticias.index').'"', false);
    }

    public function test_convocatorias_page_shows_pdf_state_sidebar_and_navigation_link(): void
    {
        $response = $this->get(route('convocatorias'));

        $response->assertOk();
        $response->assertSee('Convocatorias');
        $response->assertSee('convocatoria la casa que canta');
        $response->assertSee('Entradas del sitio');
        $response->assertSee('Archivos');
        $response->assertSee('Notas');
        $response->assertSee('href="'.route('convocatorias').'"', false);

        if (is_file(public_path('pdf/convocatoria-la-casa-que-canta.pdf'))) {
            $response->assertSee('src="'.asset('pdf/convocatoria-la-casa-que-canta.pdf').'#view=FitH&toolbar=1"', false);
            $response->assertSee('download', false);
        } else {
            $response->assertSee('El visor estará disponible cuando se agregue el PDF.');
            $response->assertSee('public/pdf');
        }
    }

    public function test_gaceta_navigation_includes_citizen_service_link(): void
    {
        $response = $this->get(route('gaceta'));

        $response->assertOk();
        $response->assertSee('aria-controls="dropdown-gaceta-menu"', false);
        $response->assertSee('href="'.route('gaceta.ediciones').'"', false);
        $response->assertSee('href="'.route('gaceta.actas').'"', false);
        $response->assertSee(
            '<a href="'.route('atencion-ciudadana').'" class="block px-4 py-2.5 text-sm font-semibold hover:bg-cyan-50 hover:text-cyan-900">Atención Ciudadana</a>',
            false,
        );
    }

    public function test_gaceta_subsections_show_pending_content_and_link_back(): void
    {
        foreach ([
            route('gaceta.ediciones') => 'Ediciones Anteriores',
            route('gaceta.actas') => 'Actas de Cabildo',
        ] as $url => $title) {
            $response = $this->get($url);

            $response->assertOk();
            $response->assertSee($title);
            $response->assertSee('estarán disponibles cuando se publiquen en este portal');
            $response->assertSee('href="'.route('gaceta').'"', false);
        }
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
        $response->assertSee('PAGAR AGUA Y PREDIAL');
        $response->assertSee('1 - En la parte superior de tu recibo');
        $response->assertSee('5 - En caso de no recibirlo');
        $response->assertSee('href="'.route('tramites.predial').'"', false);
        $response->assertSee('href="mailto:informatica@cocula.gob.mx"', false);
        $response->assertSee('Imagen de ejemplo pendiente');
        $response->assertSee('Pago de Servicios y Trámites Municipales');
        $response->assertSee('Pago de Predial');
        $response->assertSee('Licencias Municipales');
        $response->assertSee('Agua Potable y Servicios');
        $response->assertSee('>Inicio</a>', false);
    }

    public function test_predial_page_renders_consultation_form_and_handles_submission(): void
    {
        $response = $this->get(route('tramites.predial'));

        $response->assertOk();
        $response->assertSee('Impuesto Predial');
        $response->assertSee('CENTRO CP: 48500');
        $response->assertSee('MUNICIPIO DE COCULA JALISCO, JALISCO');
        $response->assertSee('name="cuenta"', false);
        $response->assertSee('name="email"', false);
        $response->assertSee('CONSULTAR');

        $postResponse = $this->post(route('tramites.predial'), [
            'cuenta' => 'U003138',
            'email' => 'ciudadano@cocula.gob.mx',
        ]);
        $postResponse->assertSessionHas('status');

        $invalidResponse = $this->post(route('tramites.predial'), [
            'cuenta' => '',
            'email' => 'invalido',
        ]);
        $invalidResponse->assertSessionHasErrors(['cuenta', 'email']);
    }

    public function test_council_page_shows_regidor_profiles_and_sidebar_content(): void
    {
        foreach ([route('regidores'), route('presidencia.regidores')] as $url) {
            $response = $this->get($url);

            $response->assertOk();
            $response->assertSee('Martha Liliana Miranda Martinez');
            $response->assertSee('Salud pública, Desarrollo social y humano, Participación ciudadana.');
            $response->assertSee('regidora.salud@cocula.gob.mx');
            $response->assertSee('Lizeth Araceli Solis Lopez');
            $response->assertSee('Educación, Cultura y Festividades Públicas.');
            $response->assertSee('regidora.educacion@cocula.gob.mx');
            $response->assertSee('Curriculum');
            $response->assertSee('Entradas del sitio');
            $response->assertSee('Archivos');
            $response->assertSee('Notas');
        }
    }

    public function test_regulations_page_embeds_the_available_sipinna_pdf_and_provides_download(): void
    {
        $this->assertFileExists(public_path('pdf/reglamentos/REGLAMENTO-SIPINNA-COCULA.pdf'));

        $response = $this->get(route('reglamentos.index'));

        $response->assertOk();
        $response->assertSee('href="'.route('reglamentos.index').'"', false);
        $response->assertSee('Reglamentos Municipales');
        $response->assertSee('Reglamento del Sistema Municipal de Protección Integral de Niñas, Niños y Adolescentes de Cocula (SIPINNA)');
        $response->assertSee('<object', false);
        $response->assertSee('data="'.asset('pdf/reglamentos/REGLAMENTO-SIPINNA-COCULA.pdf').'#view=FitH&toolbar=1"', false);
        $response->assertSee('src="'.asset('pdf/reglamentos/REGLAMENTO-SIPINNA-COCULA.pdf').'#view=FitH&toolbar=1"', false);
        $response->assertSee('href="'.asset('pdf/reglamentos/REGLAMENTO-SIPINNA-COCULA.pdf').'"', false);
        $response->assertSee('download', false);
    }

    public function test_gazette_page_displays_both_provided_pdfs_in_native_viewers_with_download_buttons(): void
    {
        $pdfDirectory = public_path('pdf/gaceta');
        $pdfPaths = [
            $pdfDirectory.'/Gaceta-09-sep-2026-Informe-segundo-ano-de-gobierno-1.pdf',
            $pdfDirectory.'/gaceta8-agosto.pdf',
        ];
        $createdDirectory = ! is_dir($pdfDirectory);
        $createdPdfs = [];

        if ($createdDirectory) {
            mkdir($pdfDirectory, 0777, true);
        }

        foreach ($pdfPaths as $pdfPath) {
            if (! is_file($pdfPath)) {
                file_put_contents($pdfPath, '%PDF-1.4');
                $createdPdfs[] = $pdfPath;
            }
        }

        try {
            $response = $this->get(route('gaceta'));

            $response->assertOk();
            $response->assertSee('<object', false);
            $response->assertSee('pdf/gaceta/Gaceta-09-sep-2026-Informe-segundo-ano-de-gobierno-1.pdf#view=FitH&toolbar=1', false);
            $response->assertSee('Gaceta-09-sep-2026-Informe-segundo-ano-de-gobierno-1.pdf#view=FitH&toolbar=1', false);
            $response->assertSee('gaceta8-agosto.pdf#view=FitH&toolbar=1', false);
            $response->assertSee('Informe segundo año de gobierno');
            $response->assertSee('Hacienda, Infraestructura Hidráulica y Acciones Municipales');
            $response->assertSee('Entradas del sitio');
            $response->assertSee('Archivos');
            $response->assertSee('Notas');
            $response->assertSee('lg:grid-cols-3', false);
            $response->assertSee('lg:col-span-2', false);
            $response->assertSee('style="height: 650px; background-color: #323639;"', false);
            $response->assertSee('style="width: 100%; height: 650px;"', false);
            $response->assertSee('class="space-y-8"', false);
            $response->assertDontSee('<table', false);
            $response->assertSee('class="btn-descarga-pill"', false);
            $response->assertSee('Descarga');
        } finally {
            foreach ($createdPdfs as $pdfPath) {
                unlink($pdfPath);
            }

            if ($createdDirectory) {
                rmdir($pdfDirectory);
            }
        }
    }

    public function test_citizen_attention_page_renders_a_demo_report_form_without_claiming_to_send_it(): void
    {
        $response = $this->get(route('atencion-ciudadana'));

        $response->assertOk();
        $response->assertSee('Atención Ciudadana y Reportes');
        $response->assertSee('no envía ni guarda la información');
        $response->assertSee('contacto@cocula.gob.mx');
        $response->assertSee('data-client-validation-only', false);
        $response->assertSee('name="tipo_incidencia"', false);
        $response->assertSee('name="fotografia"', false);
    }

    public function test_demonstration_form_pages_render_their_required_fields(): void
    {
        foreach ([
            route('solicitud-transparencia') => ['solicitante', 'email', 'detalle_solicitud', 'modalidad'],
            route('solicitud-licencia') => ['nombre_negocio', 'rfc', 'giro', 'comprobante_domicilio'],
            route('contacto') => ['nombre', 'correo', 'dependencia', 'mensaje'],
        ] as $url => $fieldNames) {
            $response = $this->get($url);

            $response->assertOk();
            $response->assertSee('data-client-validation-only', false);
            $response->assertSee('demostración');

            foreach ($fieldNames as $fieldName) {
                $response->assertSee('name="'.$fieldName.'"', false);
            }
        }
    }

    public function test_transparency_and_services_pages_link_to_their_demo_forms(): void
    {
        $transparencyResponse = $this->get(route('transparencia'));
        $servicesResponse = $this->get(route('tramites'));

        $transparencyResponse->assertOk();
        $transparencyResponse->assertSee('href="'.route('solicitud-transparencia').'"', false);
        $servicesResponse->assertOk();
        $servicesResponse->assertSee('href="'.route('solicitud-licencia').'"', false);
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

    public function test_search_returns_magic_town_committee_page(): void
    {
        $response = $this->get(route('buscar', ['q' => 'Pueblo Mágico']));

        $response->assertOk();
        $response->assertSee('Comité de Pueblo Mágico');
        $response->assertSee('href="'.route('info').'"', false);
    }

    public function test_search_returns_dif_municipal_page(): void
    {
        $response = $this->get(route('buscar', ['q' => 'DIF']));

        $response->assertOk();
        $response->assertSee('DIF Municipal');
        $response->assertSee('href="'.route('dif').'"', false);
    }

    public function test_search_returns_direct_links_for_predial_and_license_requests(): void
    {
        $predialResponse = $this->get(route('buscar', ['q' => 'predial']));
        $licenseResponse = $this->get(route('buscar', ['q' => 'licencia']));

        $predialResponse->assertOk();
        $predialResponse->assertSee('Consulta de Predial (demostración)');
        $predialResponse->assertSee('href="'.route('tramites.predial').'"', false);

        $licenseResponse->assertOk();
        $licenseResponse->assertSee('Solicitud de Licencia Comercial (demostración)');
        $licenseResponse->assertSee('href="'.route('solicitud-licencia').'"', false);
    }

    public function test_header_keeps_search_query_and_does_not_show_social_media_links(): void
    {
        $response = $this->get(route('buscar', ['q' => 'predial']));

        $response->assertOk();
        $response->assertSee('name="q" value="predial"', false);
        $response->assertDontSee('Síguenos:');
        $response->assertDontSee('aria-label="Facebook"', false);
        $response->assertDontSee('aria-label="YouTube"', false);
    }

    public function test_search_rejects_queries_longer_than_one_hundred_characters(): void
    {
        $response = $this->get(route('buscar', ['q' => str_repeat('a', 101)]));

        $response->assertRedirect();
        $response->assertSessionHasErrors('q');
    }
}
