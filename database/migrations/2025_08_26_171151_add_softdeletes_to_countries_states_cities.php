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
        // Agrega la columna deleted_at si no existe (evita errores si la agregaste antes)
        if (! Schema::hasColumn('countries', 'deleted_at')) {
            Schema::table('countries', function (Blueprint $table) {
                $table->softDeletes(); // crea 'deleted_at' nullable
            });
        }

        if (! Schema::hasColumn('states', 'deleted_at')) {
            Schema::table('states', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (! Schema::hasColumn('cities', 'deleted_at')) {
            Schema::table('cities', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        // Quita la columna deleted_at si existe
        if (Schema::hasColumn('countries', 'deleted_at')) {
            Schema::table('countries', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        if (Schema::hasColumn('states', 'deleted_at')) {
            Schema::table('states', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        if (Schema::hasColumn('cities', 'deleted_at')) {
            Schema::table('cities', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
