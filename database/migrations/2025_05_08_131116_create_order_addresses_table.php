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
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
          $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
          $table->enum('address_type',['shipping' , 'pilling'])->comment('this will help to prevent duplicate data of shipping and pilling');
          $table->string('first_name');
          $table->string('last_name');
          $table->string('email');
          $table->string('mailing_address')->nullable();
          $table->string('phone_number');
          $table->string('city');
          $table->string('postal_code')->nullable();
          $table->char('country',2);
          $table->string('state')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_addresses');
    }
};
