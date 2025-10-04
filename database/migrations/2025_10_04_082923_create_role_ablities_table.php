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
        Schema::create('role_ablities', function (Blueprint $table) {
            $table->id();
            $table->string('ability');
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->enum('type',['allow','deny','inherit'])->default('allow');
            $table->unique(['ability','role_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_ablities');
    }
};
