<?php

namespace App\Http\Controllers\Websites;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Homepage extends Controller
{
    public function blogIndex(Request $request)
    {
        $search = $request->query('search', 'programming');
        
        $response = Http::get("https://openlibrary.org/search.json", [
            'q' => $search,
            // 'limit' => 12 
        ]);

        $allBooks = [];

        if ($response->successful()) {
            $docs = $response->json()['docs'] ?? [];

            foreach ($docs as $book) {
                // Pembersihan ID
                $rawId = $book['key'] ?? ''; 
                $cleanId = str_replace('/works/', '', $rawId);

                // Setup Cover
                $coverId = $book['cover_i'] ?? null;
                $coverUrl = $coverId 
                    ? "https://covers.openlibrary.org/b/id/{$coverId}-L.jpg" 
                    : null;

                // Ambil kategori buku, jika tidak ada berikan kategori umum
                $dynamicCategory = 'Umum';
                if (isset($book['subject']) && is_array($book['subject']) && count($book['subject']) > 0) {
                    $dynamicCategory = $book['subject'][0]; 
                }

                $allBooks[] = [
                    'id'        => $cleanId,
                    'title'     => $book['title'] ?? 'Tanpa Judul',
                    'author'    => isset($book['author_name']) ? implode(', ', $book['author_name']) : 'Anonim',
                    'publisher' => isset($book['publisher']) ? $book['publisher'][0] : 'Penerbit Umum',
                    'year'      => $book['first_publish_year'] ?? null,
                    'cover'     => $coverUrl,
                    'category'  => [
                        'name' => $dynamicCategory,
                    ],
                ];
            }
        }

        return Inertia::render('Websites/Homepage', [
            'allBooks' => $allBooks,
            'filters'  => $request->only(['search'])
        ]);
    }
}