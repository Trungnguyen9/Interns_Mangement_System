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
        Schema::create('weekly_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intern_profile_id')->constrained('intern_profiles')->onDelete('cascade'); 
            $table->text('completed_tasks');
            $table->text('difficulties')->nullable();
            $table->text('next_plan');
            $table->string('reference_links')->nullable();
            $table->text('mentor_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_reports');
    }
};
