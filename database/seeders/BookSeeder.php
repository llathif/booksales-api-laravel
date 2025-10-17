<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create([
            'title' => 'Bumi',
            'description' => 'Petualangan Raib, Seli, dan Ali di dunia paralel.',
            'price' => 99000,
            'stock' => 50,
            'genre_id' => 3, // ID untuk genre Fantasy
            'author_id' => 1, // ID untuk Tere Liye
        ]);

        Book::create([
            'title' => 'Laskar Pelangi',
            'description' => 'Kisah inspiratif anak-anak dari Belitung.',
            'price' => 85000,
            'stock' => 45,
            'genre_id' => 2, // ID untuk genre Romance
            'author_id' => 3, // ID untuk Andrea Hirata
        ]);

        Book::create([
            'title' => 'Harry Potter and the Sorcerer\'s Stone',
            'description' => 'Awal mula kisah penyihir muda di Hogwarts.',
            'price' => 125000,
            'stock' => 30,
            'genre_id' => 3, // ID untuk genre Fantasy
            'author_id' => 2, // ID untuk J.K. Rowling
        ]);

        Book::create([
            'title' => 'Perahu Kertas',
            'description' => 'Kisah cinta Keenan dan Kugy yang penuh lika-liku.',
            'price' => 78000,
            'stock' => 60,
            'genre_id' => 2, // ID untuk genre Romance
            'author_id' => 5, // ID untuk Dee Lestari
        ]);

        Book::create([
            'title' => 'Bumi Manusia',
            'description' => 'Kisah Minke di zaman kolonial Hindia Belanda.',
            'price' => 110000,
            'stock' => 25,
            'genre_id' => 1, // ID untuk genre Action (sebagai contoh)
            'author_id' => 4, // ID untuk Pramoedya Ananta Toer
        ]);
    }
}
