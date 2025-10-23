<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index() {

        $transactions = Transaction::with('user', 'book')->get();

        if ($transactions->isEmpty()) {
            return response()->json([
                "success" => true,
                "message" => "Resource data not found!"
            ], 200);
        }

        return response()->json([
            "success" => true,
            "message" => "Data Transaksi Berhasil Diambil",
            "data" => $transactions
        ]);
    }

    public function store(Request $request) {
        // 1. Validator & cek validator
        $validator = Validator::make($request->all(), [
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error!',
                'data' => $validator->errors()
            ], 422);
        }

        // 2. generate order number
        $uniqueCode = 'ORD-' . strtoupper(uniqid());

        // 3. ambil user yang sedang login
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // 4. mencari data buku
        $book = Book::find($request->book_id);

        // 5. cek stock buku
        if ($book->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stok barang tidak cukup!',
            ], 400);
        }

        // 6. hitung total harga
        $totalAmount = $book->price * $request->quantity;

        // 7. kurangi stock buku
        $book->stock -= $request->quantity;
        $book->save();

        // 8. simpan data transaksi
        $transaction = Transaction::create([
            'order_number' => $uniqueCode,
            'customer_id' => $user->id,
            'book_id' => $request->book_id,
            'quantity' => $request->quantity,
            'total_amount' => $totalAmount
        ]);
        
        // Muat relasi agar data user dan buku ikut terkirim di respons
        $transaction->load('user', 'book');

        return response()->json([
            'success' => true,
            'message' => 'Transaction created successfully!',
            'data' => $transaction
        ], 201);
    }

    public function show(string $id)
    {
        // 1. Cari transaksi dan muat relasinya
        $transaction = Transaction::with('user', 'book')->find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found!',
            ], 404);
        }

        // 2. Cek otorisasi
        $user = auth('api')->user();
        if ($user->role !== 'admin' && $user->id !== $transaction->customer_id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to view this resource.'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get detail resource',
            'data' => $transaction
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        // 1. Cari transaksi
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found!',
            ], 404);
        }

        // 2. Cek Otorisasi (Hanya pemilik yang bisa update)
        $user = auth('api')->user();
        if ($user->id !== $transaction->customer_id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this resource.'
            ], 403);
        }
        
        // 3. Validator (Customer hanya boleh mengirim status 'cancelled')
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:cancelled'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error! You can only set status to "cancelled".',
                'data' => $validator->errors()
            ], 422);
        }
        
        // 4. Cek apakah sudah dibatalkan sebelumnya
        if ($transaction->status == 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'This transaction has already been cancelled.'
            ], 400);
        }

        // 5. Kembalikan stok buku
        $book = Book::find($transaction->book_id);
        if ($book) {
            $book->stock += $transaction->quantity;
            $book->save();
        }
        
        // 6. Update status transaksi
        $transaction->status = 'cancelled';
        $transaction->save();

        return response()->json([
            'success' => true,
            'message' => 'Transaction cancelled successfully!',
            'data' => $transaction
        ], 200);
    }

    public function destroy(string $id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Resource not found!',
            ], 404);
        }
        
        $user = auth('api')->user();
        if ($user->role !== 'admin' && $user->id !== $transaction->customer_id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to delete this resource.'
            ], 403);
        }

        // 1. Kembalikan stok buku
        // (Kita cek dulu jika statusnya BUKAN 'cancelled', agar stok tidak dobel kembali)
        if ($transaction->status !== 'cancelled') {
             $book = Book::find($transaction->book_id);
             if ($book) {
                $book->stock += $transaction->quantity;
                $book->save();
            }
        }

        // 2. Hapus transaksi
        $transaction->delete();

        return response()->json([
            'success' => true,
            'message' => 'Transaction deleted (cancelled) successfully!'
        ], 200);
    }
}