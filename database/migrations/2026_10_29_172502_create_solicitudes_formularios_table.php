<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('solicitudes_formularios', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique();
            $table->enum('modulo_origen', ['DIF', 'TRANSPARENCIA', 'ACCESIBILIDAD', 'CONTACTO_GENERAL']);
            $table->string('nombre_completo');
            $table->string('email');
            $table->string('telefono', 20)->nullable();
            $table->string('curp', 18)->nullable();
            $table->string('asunto');
            $table->text('mensaje_solicitud');
            $table->enum('estatus', ['PENDIENTE', 'EN_REVISION', 'ATENDIDO', 'RECHAZADO'])->default('PENDIENTE');
            $table->text('observaciones_internas')->nullable();
            $table->timestamps();

            $table->index(['modulo_origen', 'created_at']);
            $table->index(['estatus', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solicitudes_formularios');
    }
};
