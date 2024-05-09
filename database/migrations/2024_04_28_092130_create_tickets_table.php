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
<<<<<<< HEAD
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
=======
            $table->foreignId('application_id')->constrained()->onDelete('cascade');
>>>>>>> 7300c5caa7056006324d5c9a26a6f8206b730999
            $table->foreignId('problem_category_id')->constrained('problem_categories')->onDelete('cascade');
            $table->string('object');
            $table->text('content');
            $table->enum('status', ['Nouveau', 'Terminé', 'En cours'])->default('Nouveau');
<<<<<<< HEAD
            $table->json('uploaded_files')->nullable();
=======
            $table->string('uploaded_files')->nullable();
>>>>>>> 7300c5caa7056006324d5c9a26a6f8206b730999
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
