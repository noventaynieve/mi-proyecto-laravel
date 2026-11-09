<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('activo')->default(true)->after('role');
        });

        DB::table('users')
            ->where('role', 'admin')
            ->update(['role' => 'super_admin']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('users')
            ->where('role', 'super_admin')
            ->update(['role' => 'admin']);

        DB::table('users')
            ->whereIn('role', ['editor_general', 'transparencia', 'admin_dif', 'catastro'])
            ->update(['role' => 'user']);

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('activo');
        });
    }
};
