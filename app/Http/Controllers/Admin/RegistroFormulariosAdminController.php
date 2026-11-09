<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SolicitudFormulario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistroFormulariosAdminController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'modulo' => ['nullable', 'in:'.implode(',', SolicitudFormulario::MODULOS_ORIGEN)],
            'estatus' => ['nullable', 'in:'.implode(',', SolicitudFormulario::ESTATUS)],
        ]);

        $query = SolicitudFormulario::query();

        if (! empty($filters['modulo'])) {
            $query->where('modulo_origen', $filters['modulo']);
        }

        if (! empty($filters['estatus'])) {
            $query->where('estatus', $filters['estatus']);
        }

        return view('admin.formularios.index', [
            'solicitudes' => $query
                ->latest('created_at')
                ->latest('id')
                ->paginate(15)
                ->withQueryString(),
            'totales' => [
                'todos' => SolicitudFormulario::query()->count(),
                'pendientes' => SolicitudFormulario::query()->where('estatus', 'PENDIENTE')->count(),
                'dif' => SolicitudFormulario::query()->where('modulo_origen', 'DIF')->count(),
                'transparencia' => SolicitudFormulario::query()->where('modulo_origen', 'TRANSPARENCIA')->count(),
            ],
        ]);
    }

    public function updateEstatus(Request $request, SolicitudFormulario $solicitudFormulario): RedirectResponse
    {
        $validated = $request->validate([
            'estatus' => ['required', 'in:'.implode(',', SolicitudFormulario::ESTATUS)],
            'observaciones_internas' => ['nullable', 'string', 'max:5000'],
        ]);

        $solicitudFormulario->update($validated);

        return redirect()
            ->route('admin.formularios.index', $request->query())
            ->with('status', 'Estatus actualizado correctamente para el folio '.$solicitudFormulario->folio.'.');
    }
}
