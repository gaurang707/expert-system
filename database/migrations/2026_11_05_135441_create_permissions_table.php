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
        Schema::create('permissions', function (Blueprint $table) {
            $table->engine('InnoDB');
            $table->id();
            $table->foreignId('module_id')->constrained()->restrictOnDelete();
            $table->foreignId('action_id')->constrained()->restrictOnDelete();
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->unique(['module_id', 'action_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
