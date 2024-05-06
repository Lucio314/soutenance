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
        Schema::create('gerers', function (Blueprint $table) {
            $table->primary(['technician_id', 'problem_category_id']);
            $table->unsignedBigInteger('technician_id');
            $table->unsignedBigInteger('problem_category_id');
            $table->timestamps();

            // Clés étrangères
            $table->foreign('technician_id')->references('id')->on('technicians')->onDelete('cascade');
            $table->foreign('problem_category_id')->references('id')->on('problem_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gerers');
    }
};
