<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genre::create([
            'name' => 'Action',
            'description' => 'Genre yang menekankan pada adegan aksi, pertempuran dan kecepatan'
        ]);

        Genre::create([
            'name' => 'Fantasi',
            'description' => 'Genre yang menggunakan unsur sihir, dunia mitos, dan petualangan supernatural.'
        ]);

        Genre::create([
            'name' => 'Misteri',
            'description' => 'Genre yang berfokus pada pemecahan teka-teki atau kejahatan yang membingungkan.'
        ]);

        Genre::create([
            'name' => 'Roman',
            'description' => 'Genre yang berpusat pada kisah cinta dan hubungan emosional antar karakter.'
        ]);

        Genre::create([
            'name' => 'Horor',
            'description' => 'Genre yang bertujuan untuk menimbulkan rasa takut, ngeri, atau ketegangan pada pembaca.'
        ]);
    }
}
