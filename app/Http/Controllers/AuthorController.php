<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // <-- JANGAN LUPA IMPORT

class AuthorController extends Controller
{
    /**
     * Menampilkan semua data resource.
     */
    public function index()
    {
        $authors = Author::all();

        if ($authors->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resource data not found!"
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Data Penulis Berhasil Diambil",
            "data" => $authors
        ]);
    }

    /**
     * Menyimpan resource baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
        ]);

        // 2. Cek kegagalan validator
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422); // 422 Unprocessable Entity
        }

        // 3. Masukkan data
        $author = Author::create([
            'name' => $request->name,
        ]);

        // 4. Beri respons sukses
        return response()->json([
            'success' => true,
            'message' => 'New Author added successfully!',
            'data' => $author
        ], 201); // 201 Created
    }
}