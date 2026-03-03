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
        Schema::create('book_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // nullable() agar bisa menyimpan buku dari API luar
            $table->foreignId('book_id')->nullable()->constrained()->cascadeOnDelete();
            
            // Untuk menyimpan ID unik dari Open Library
            $table->string('external_id')->nullable();
            
            $table->timestamp('granted_at')->useCurrent(); // Kapan akses diberikan
            $table->timestamp('expired_at')->nullable();  // Jika akses selamanya, biarkan NULL
            
            // Status disesuaikan dengan kebutuhan marketplace
            $table->enum('status', ['active', 'expired', 'revoked'])->default('active');
            $table->string('access_type')->default('free'); // free, premium, purchase

            $table->softDeletes();  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
