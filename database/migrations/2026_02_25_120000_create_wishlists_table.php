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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // nullable() agar bisa menyimpan buku dari API luar
            $table->foreignId('book_id')->nullable()->constrained()->cascadeOnDelete();
            
            // Untuk menyimpan ID unik dari Open Library
            $table->string('external_id')->nullable();

            // Pastikan user tidak menyimpan buku yang sama dua kali
            $table->unique(['user_id', 'book_id', 'external_id']);
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
