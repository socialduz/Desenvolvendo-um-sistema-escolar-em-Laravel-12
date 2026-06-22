<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('curso_disciplina', function (Blueprint $table) {
            $table->date('dt_create')->nullable();
            $table->date('dt_update')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('curso_disciplina', function (Blueprint $table) {
            $table->dropColumn(['dt_create', 'dt_update']);
        });
    }
};
