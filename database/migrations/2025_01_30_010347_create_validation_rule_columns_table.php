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
        Schema::create('validation_rule_columns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('validation_rule_id')->constrained('validation_rules')->onUpdate('cascade')->onDelete('cascade');
            $table->string('column');
            $table->json(column: 'rules')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validation_rule_columns');
    }
};
