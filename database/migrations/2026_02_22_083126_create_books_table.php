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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            // Nullable() untuk buku API tidak wajib punya kategori di DB
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('title');
            $table->string('author');
            $table->string('publisher')->nullable();
            $table->integer('published_year')->nullable();
            $table->string('isbn')->nullable()->unique();
            $table->string('external_id')->nullable()->unique(); 
            $table->text('description')->nullable();
            $table->string('cover_url')->nullable(); 
            $table->string('file_path')->nullable(); 
            
            // Fitur Openov Marketplace
            $table->decimal('price', 10, 2)->default(0.00); 
            $table->boolean('is_premium')->default(false);
            
            $table->integer('view_count')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
