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
        Schema::create('carts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cookie_id'); // we use this to store it in user cookie , 
            //this not be unique because there where many products in same cart take same cookie_id
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete(); //to know this cart for any user if the user is authed
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->unsignedSmallInteger('quantity')->default(1);
            $table->json('options')->nullable();   // we need this column to store on it the value color size of each product
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
