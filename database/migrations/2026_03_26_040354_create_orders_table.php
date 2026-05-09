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
            $table->string('invoice_number', 20);
            $table->string('customer_name', 100);
            $table->string('customer_number', 20);
            $table->string('delivery_address'); // agregamos delivery_address
            $table->dateTime('order_datetime')->nullable(); // opcional si quieres permitir vacío
            $table->text('notes')->nullable();
            $table->enum('status', ['Ordered', 'In process', 'In route', 'Delivered']);
            $table->boolean('is_deleted')->default(false);
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