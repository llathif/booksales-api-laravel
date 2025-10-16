<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    private $books = [
        [
            'title' => 'Pulang',
            'description' => 'Petualangan seorang pemuda yang kembali ke desa kelahiranya.',
            'price' => 40000,
            'stock' => 15,
            'cover_photo' => 'Pulang.jpg',
            'genre_id' => 1,
            'author_id' => 1
        ],
        [
            'title' => 'Sebuah Seni untuk Bersikap Bodo Amat',
            'description' => 'Buku yang membahas tentang kehidupan dan filosofi hidup seseorang.',
            'price' => 25000,
            'stock' => 5,
            'cover_photo' => 'sebuah_seni.jpg',
            'genre_id' => 2,
            'author_id' => 2
        ],
        [
            'title' => 'Filosofi Teras',
            'description' => 'Buku yang menjelaskan konsep stoisisme dan cara menghadapi emosi dalam kehidupan modern.',
            'price' => 30000,
            'stock' => 7,
            'cover_photo' => 'filosofi_teras.jpg',
            'genre_id' => 3,
            'author_id' => 3,
        ]
    ];

    public function getBooks() {
        return $this->books;
    }
}
