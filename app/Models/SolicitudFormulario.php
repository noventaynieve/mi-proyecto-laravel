<?php

namespace App\Models;

use Database\Factories\SolicitudFormularioFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudFormulario extends Model
{
    /** @use HasFactory<SolicitudFormularioFactory> */
    use HasFactory;

    protected $table = 'solicitudes_formularios';

    public const MODULOS_ORIGEN = [
        'DIF',
        'TRANSPARENCIA',
        'ACCESIBILIDAD',
        'CONTACTO_GENERAL',
    ];

    public const ESTATUS = [
        'PENDIENTE',
        'EN_REVISION',
        'ATENDIDO',
        'RECHAZADO',
    ];

    protected $fillable = [
        'folio',
        'modulo_origen',
        'nombre_completo',
        'email',
        'telefono',
        'curp',
        'asunto',
        'mensaje_solicitud',
        'estatus',
        'observaciones_internas',
    ];
}
