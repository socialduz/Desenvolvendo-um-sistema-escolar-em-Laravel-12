<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cargo', function (Blueprint $table) {
            if (! Schema::hasColumn('cargo', 'status')) {
                $table->smallInteger('status')->default(1);
            }

            if (! Schema::hasColumn('cargo', 'dt_create')) {
                $table->date('dt_create')->nullable();
            }

            if (! Schema::hasColumn('cargo', 'dt_update')) {
                $table->date('dt_update')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('cargo', function (Blueprint $table) {
            if (Schema::hasColumn('cargo', 'status')) {
                $table->dropColumn('status');
            }

            if (Schema::hasColumn('cargo', 'dt_create')) {
                $table->dropColumn('dt_create');
            }

            if (Schema::hasColumn('cargo', 'dt_update')) {
                $table->dropColumn('dt_update');
            }
        });
    }
};
