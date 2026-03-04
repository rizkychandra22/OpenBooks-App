<?php

namespace App\Http\Controllers\Websites;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Inertia\Inertia;

class Homepage extends Controller
{
    /**
     * Tampilan Katalog Utama
     */
    public function blogIndex(Request $request)
    {
        $response = Http::get("https://openlibrary.org/search.json", [
            'q' => 'first_publish_year:[1500 TO 2026] AND has_fulltext:true', 
            'language' => 'ind', 
            'limit' => 100,
            'fields' => 'key,title,author_name,cover_i,subject,description,first_publish_year,publisher,isbn,first_sentence',
            'offset' => rand(0, 100)
        ]);

        $allBooks = [];

        if ($response->successful()) {
            $docs = $response->json()['docs'] ?? [];
            foreach ($docs as $book) {
                // Panggil fungsi global formatter (mode list)
                $allBooks[] = $this->formatBookData($book, 'list');
            }
        }

        return Inertia::render('Websites/Homepage', [
            'allBooks' => $allBooks,
        ]);
    }

    /**
     * Tampilan Detail Buku
     */
    public function show($id)
    {
        $response = Http::get("https://openlibrary.org/search.json", [
            'q' => 'key:/works/' . $id,
            'fields' => 'key,title,author_name,cover_i,subject,description,first_publish_year,publisher,isbn,first_sentence'
        ]);

        if ($response->successful() && !empty($response->json()['docs'])) {
            $bookData = $response->json()['docs'][0];
            
            // Panggil fungsi global formatter (mode detail)
            return Inertia::render('Websites/BooksDetail', [
                'book' => $this->formatBookData($bookData, 'detail', $id)
            ]);
        }

        return redirect()->route('homepage');
    }

    /**
     * FUNGSI GLOBAL FORMATTER (Private Method)
     * Menyatukan logika pemetaan agar rapi
     */
    private function formatBookData($data, $mode = 'list', $externalId = null)
    {
        // 1. Olah Penulis
        $authors = isset($data['author_name']) ? implode(', ', $data['author_name']) : 'Anonim';

        // 2. Olah Kategori (Subject)
        $subjects = $data['subject'] ?? [];
        if ($mode === 'list') {
            // Jika di list, batasi 2 kategori dan potong teksnya
            $limited = array_slice($subjects, 0, 2);
            $text = !empty($limited) ? implode(', ', $limited) : 'Umum';
            $category = (strlen($text) > 30) ? substr($text, 0, 30) . '...' : $text;
        } else {
            // Jika di detail, tampilkan semua tanpa potongan
            $category = !empty($subjects) ? implode(', ', $subjects) : 'Umum';
        }

        // 3. Olah Deskripsi
        $desc = 'Tidak ada deskripsi tersedia.';
        if (isset($data['first_sentence'])) {
            $desc = is_array($data['first_sentence']) ? $data['first_sentence'][0] : $data['first_sentence'];
        }

        // 4. Olah Cover
        $coverId = $data['cover_i'] ?? null;
        $coverUrl = $coverId ? "https://covers.openlibrary.org/b/id/{$coverId}-L.jpg" : null;

        // Return array sesuai kebutuhan schema
        return [
            'external_id'    => $externalId ?? str_replace('/works/', '', ($data['key'] ?? uniqid())),
            'title'          => $data['title'] ?? 'Tanpa Judul',
            'category_name'  => $category,
            'author'         => $authors,
            'publisher'      => isset($data['publisher']) ? $data['publisher'][0] : 'Penerbit Umum',
            'published_year' => $data['first_publish_year'] ?? 'Tidak tersedia',
            'isbn'           => isset($data['isbn']) ? implode(', ', $data['isbn']) : 'Tidak tersedia',
            'description'    => $desc,
            'cover_url'      => $coverUrl,
            'price'          => 0.00,
            'is_premium'     => false,
        ];
    }
}