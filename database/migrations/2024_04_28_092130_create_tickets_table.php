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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('client_email');
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
            $table->foreignId('problem_category_id')->constrained('problem_categories')->onDelete('cascade');
            $table->string('object');
            $table->text('content');
            $table->enum('status', ['Nouveau', 'Terminé', 'En cours','Annuler'])->default('Nouveau');
            $table->json('uploaded_files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
