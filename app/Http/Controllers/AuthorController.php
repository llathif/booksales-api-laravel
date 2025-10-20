<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule; 

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
            // Sebaiknya tambahkan 'unique' agar tidak ada nama yang sama
            'name' => 'required|string|max:100|unique:authors',
        ]);

        // 2. Cek kegagalan validator
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
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
        ], 201);
    }

    /**
     * Menampilkan detail satu data author.
     */
    public function show(string $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found!',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get detail resource',
            'data' => $author
        ], 200);
    }

    /**
     * Memperbarui data author yang ada.
     */
    public function update(string $id, Request $request)
    {
        // 1. Mencari data
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found!',
            ], 404);
        }

        // 2. Validator
        $validator = Validator::make($request->all(), [
            // Aturan 'unique' yang mengabaikan ID author itu sendiri
            'name' => 'required|string|max:100|unique:authors,name,' . $author->id,
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
        ];

        // 4. Update data
        $author->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Resource updated successfully!',
            'data' => $author
        ], 200);
    }

    /**
     * Menghapus data author.
     */
    public function destroy(string $id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found!',
            ], 404);
        }

        /*
        // Opsional: Cek jika author masih dipakai oleh buku
        if ($author->books()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete author, he/she is currently in use by books.'
            ], 409); // 409 Conflict
        }
        */

        $author->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete resource successfully!'
        ], 200);
    }
}