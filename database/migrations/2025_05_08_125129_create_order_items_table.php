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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete()->comment('we will make this column nullable , so if admin want to delete product');
            $table->string('product_name')->comment('if the admin change product name or delete it ');
            $table->float('product_price')->comment('if the admin change product price old orders not affected');
            $table->unsignedSmallInteger('quantity')->default(1);
            $table->json('options')->nullable();
            $table->unique(['order_id' , 'product_id']);

            // we delete timestamp column to we don't need the created_at or updated_at --remember to tell him in the model .

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
