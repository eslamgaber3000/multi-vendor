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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete()->comment('this will be null to allow make user make order if he is not authed');
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->string('order_number')->unique();
            $table->enum('status',['pending','processing','delivering','completed','canceled','refunding'])
            ->default('pending') ;
            $table->enum('payment-status',['pending','paid','failed'])->default('pending');
            $table->string('payment_method');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
