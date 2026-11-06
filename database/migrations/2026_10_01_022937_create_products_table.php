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
            $table->string('categoria')->default('ropa'); // 'ropa', 'calzado', 'accesorios'
            
            // Stock para Ropa (S, M, L, XL)
            $table->integer('stock_s')->default(0);
            $table->integer('stock_m')->default(0);
            $table->integer('stock_l')->default(0);
            $table->integer('stock_xl')->default(0);

            // Stock para Calzado (26, 27, 28, 29)
            $table->integer('stock_26')->default(0);
            $table->integer('stock_27')->default(0);
            $table->integer('stock_28')->default(0);
            $table->integer('stock_29')->default(0);

            // Stock General (para Accesorios u otros)
            $table->integer('stock')->default(0);

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