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
        Schema::table('intern_profiles', function (Blueprint $table) {
            $table->enum('status', ['Đang thực tập', 'Đã hoàn thành'])->default('Đang thực tập')->change();
        });
    }

    /**
     * Reverse the migrations.  
     */
    public function down(): void
    {
        Schema::table('intern_profiles', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
