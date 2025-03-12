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
        Schema::create('data_generations', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'template_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->json('data')->nullable();
            $table->unsignedBigInteger(column: 'user_id')->nullable();
            $table->date('processing_date')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->enum('validation', ['success', 'error', 'pending'])->default('pending');
            $table->enum('approval', ['success', 'error', 'pending'])->default('pending');
            $table->enum('integration', ['success', 'error', 'pending'])->default('pending');
            $table->enum('archival', ['success', 'error', 'pending'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_generations');
    }
};
