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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('cpn_name');
            $table->string('cpn_email');
            $table->string('company_phone');
            $table->string('cpn_address');
            $table->boolean('is_active')->default(false);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Ajout de la clé étrangère user_id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
