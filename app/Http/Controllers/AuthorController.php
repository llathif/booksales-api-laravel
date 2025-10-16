<?php

namespace App\Http\Controllers;

use App\Models\Author; // Jangan lupa import modelnya
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $data = new Author(); // Membuat objek baru dari model Author
        $authors = $data->getAuthors(); // Mengambil data authors
        return view('authors', ['authors' => $authors]); // Mengirim data ke view 'author'
    }
}