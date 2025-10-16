<?php

namespace App\Http\Controllers;

use App\Models\Genre; // Jangan lupa import modelnya
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $data = new Genre(); // Membuat objek baru dari model Genre
        $genres = $data->getGenres(); // Mengambil data genres
        return view('genres', ['genres' => $genres]); // Mengirim data ke view 'genre'
    }
}