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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('precio', 8, 2);
            $table->text('imagen');
            $table->string('categoria')->default('ropa');
            // Campos de inventario por talla
            $table->integer('stock_s')->default(0);
            $table->integer('stock_m')->default(0);
            $table->integer('stock_l')->default(0);
            $table->integer('stock_xl')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};