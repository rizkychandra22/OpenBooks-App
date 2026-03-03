<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Nama kategori yang nanti akan dimiliki sesuai kebutuhan 
        $categories = [
            'Fiction',
            'Non-Fiction',
            'Science',
            'History',
            'Biography',
            'Romance',
            'Fantasy',
            'Horror',
            'Mystery',
            'Thriller'
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
                'code_name' => Str::slug($category),  // Membuat slug dengan (-) dari nama kategori
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}