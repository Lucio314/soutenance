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
        Schema::create('travaillers', function (Blueprint $table) {
            $table->primary(['technician_id','ticket_id']);
            $table->unsignedBigInteger('technician_id');
            $table->unsignedBigInteger('ticket_id');
            $table->boolean('is_transferred')->default(false);
            $table->unsignedBigInteger('transferred_to')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('technician_id')->references('id')->on('technicians')->onDelete('cascade');
            $table->foreign('ticket_id')->references('id')->on('tickets')->onDelete('cascade');
            $table->foreign('transferred_to')->references('id')->on('technicians')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travaillers');
    }
};

