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
        Schema::create('data_archivals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_generation_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('template_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_archivals');
    }
};
