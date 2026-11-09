<?php

namespace Tests\Feature;

use App\Models\SolicitudFormulario;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistroFormulariosTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_the_registry(): void
    {
        $this->get(route('admin.formularios.index'))
            ->assertRedirectToRoute('login');
    }

    public function test_user_without_panel_access_cannot_open_the_registry(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('admin.formularios.index'))
            ->assertForbidden();
    }

    public function test_panel_user_can_filter_requests_and_see_registry_totals(): void
    {
        $user = User::factory()->admin()->create();
        SolicitudFormulario::factory()->create([
            'folio' => 'DIF-2026-001',
            'modulo_origen' => 'DIF',
            'estatus' => 'PENDIENTE',
        ]);
        SolicitudFormulario::factory()->create([
            'folio' => 'TRANSP-2026-001',
            'modulo_origen' => 'TRANSPARENCIA',
            'estatus' => 'PENDIENTE',
        ]);
        SolicitudFormulario::factory()->create([
            'folio' => 'DIF-2026-002',
            'modulo_origen' => 'DIF',
            'estatus' => 'ATENDIDO',
        ]);

        $this->actingAs($user)
            ->get(route('admin.formularios.index', [
                'modulo' => 'DIF',
                'estatus' => 'PENDIENTE',
            ]))
            ->assertOk()
            ->assertSee('Registro General de Formularios')
            ->assertSee('Registro de formularios')
            ->assertSee('DIF-2026-001')
            ->assertDontSee('TRANSP-2026-001')
            ->assertDontSee('DIF-2026-002')
            ->assertViewHas('totales', [
                'todos' => 3,
                'pendientes' => 2,
                'dif' => 2,
                'transparencia' => 1,
            ])
            ->assertViewHas('solicitudes', fn ($solicitudes): bool => $solicitudes->total() === 1);
    }

    public function test_panel_user_can_update_status_and_internal_notes(): void
    {
        $user = User::factory()->admin()->create();
        $solicitud = SolicitudFormulario::factory()->create([
            'folio' => 'DIF-2026-003',
            'modulo_origen' => 'DIF',
        ]);
        $url = route('admin.formularios.updateEstatus', [
            'solicitudFormulario' => $solicitud,
            'modulo' => 'DIF',
            'estatus' => 'PENDIENTE',
        ]);

        $this->actingAs($user)
            ->patch($url, [
                'estatus' => 'RECHAZADO',
                'observaciones_internas' => 'Se informó al solicitante.',
            ])
            ->assertRedirectToRoute('admin.formularios.index', [
                'modulo' => 'DIF',
                'estatus' => 'PENDIENTE',
            ])
            ->assertSessionHas('status', 'Estatus actualizado correctamente para el folio DIF-2026-003.');

        $this->assertDatabaseHas('solicitudes_formularios', [
            'id' => $solicitud->id,
            'estatus' => 'RECHAZADO',
            'observaciones_internas' => 'Se informó al solicitante.',
        ]);
    }

    public function test_user_without_panel_access_cannot_update_a_request(): void
    {
        $user = User::factory()->create();
        $solicitud = SolicitudFormulario::factory()->create([
            'folio' => 'DIF-2026-005',
            'modulo_origen' => 'DIF',
            'estatus' => 'PENDIENTE',
        ]);

        $this->actingAs($user)
            ->patch(route('admin.formularios.updateEstatus', $solicitud), [
                'estatus' => 'ATENDIDO',
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('solicitudes_formularios', [
            'id' => $solicitud->id,
            'estatus' => 'PENDIENTE',
        ]);
    }

    public function test_invalid_status_and_overlong_notes_do_not_update_a_request(): void
    {
        $user = User::factory()->admin()->create();
        $solicitud = SolicitudFormulario::factory()->create([
            'folio' => 'DIF-2026-004',
            'modulo_origen' => 'DIF',
            'estatus' => 'PENDIENTE',
        ]);

        $this->actingAs($user)
            ->from(route('admin.formularios.index'))
            ->patch(route('admin.formularios.updateEstatus', $solicitud), [
                'estatus' => 'INVALIDO',
                'observaciones_internas' => str_repeat('a', 5001),
            ])
            ->assertSessionHasErrors(['estatus', 'observaciones_internas']);

        $this->assertDatabaseHas('solicitudes_formularios', [
            'id' => $solicitud->id,
            'estatus' => 'PENDIENTE',
            'observaciones_internas' => null,
        ]);
    }

    public function test_registry_rejects_unknown_filter_values(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->from(route('admin.formularios.index'))
            ->get(route('admin.formularios.index', ['modulo' => 'NO_EXISTE']))
            ->assertSessionHasErrors('modulo');
    }
}
