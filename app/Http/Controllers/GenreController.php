<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator; // <-- TAMBAHKAN IMPORT INI

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

    public function store(Request $request)
    {
        // 1. Validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100|unique:genres',
            'description' => 'nullable|string', // nullable berarti boleh kosong
        ]);

        // 2. Cek kegagalan validator
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. Masukkan data
        $genre = Genre::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // 4. Beri respons sukses
        return response()->json([
            'success' => true,
            'message' => 'New Genre added successfully!',
            'data' => $genre
        ], 201);
    }

    public function show(string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found!',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get detail resource',
            'data' => $genre
        ], 200);
    }

    public function update(string $id, Request $request)
    {
        // 1. Mencari data
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found!',
            ], 404);
        }

        // 2. Validator
        $validator = Validator::make($request->all(), [
            // Aturan 'unique' di sini harus mengabaikan ID genre itu sendiri
            'name' => 'required|string|max:100|unique:genres,name,' . $genre->id,
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // 3. Siapkan data baru
        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        // 4. Update data
        $genre->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Resource updated successfully!',
            'data' => $genre
        ], 200);
    }

    public function destroy(string $id)
    {
        $genre = Genre::find($id);

        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found!',
            ], 404);
        }

        /*
        // Opsional: Cek jika genre masih dipakai oleh buku
        if ($genre->books()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete genre, it is currently in use by books.'
            ], 409); // 409 Conflict
        }
        */

        $genre->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete resource successfully!'
        ], 200);
    }
}