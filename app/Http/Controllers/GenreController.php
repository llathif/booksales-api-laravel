<?php

namespace App\Http\Controllers;

use App\Models\Genre; // Jangan lupa import modelnya
use Illuminate\Http\Request;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();

        if ($genres->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resource data not found!"
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Data Genre Berhasil Diambil",
            "data" => $genres
        ]);
    }
}