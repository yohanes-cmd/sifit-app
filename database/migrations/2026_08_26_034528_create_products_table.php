<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Foreign Key ke tabel users (pencatat data)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Foreign Key ke tabel categories
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->string('image')->nullable();
            $table->enum('status', ['published', 'draft', 'inactive'])->default('published');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};