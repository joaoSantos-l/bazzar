<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('productName', 255);
            $table->string('seller', length: 30);
            $table->text('description');
            $table->integer('stock');
            $table->double('price');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};