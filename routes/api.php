<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\TransactionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:api']);

Route::middleware(['auth:api'])->group(function () {
    Route::apiResource('/transactions', TransactionController::class)->only(['store', 'show', 'update']);


    Route::middleware(['role:admin'])->group(function() {
        Route::apiResource('/books', BookController::class)->only(['store', 'update', 'destroy']);

        Route::apiResource('/genres', GenreController::class)->only(['store', 'update', 'destroy']);

        Route::apiResource('/authors', AuthorController::class)->only(['store', 'update', 'destroy']);

        Route::apiResource('/transactions', TransactionController::class)->only(['index', 'destroy']);
    });

});

//Route::get('/books', [BookController::class, 'index']);
//Route::post('/books', [BookController::class, 'store']);
//Route::get('/books/{id}', [BookController::class, 'show']);
//Route::post('/books/{id}', [BookController::class, 'update']);
//Route::delete('/books/{id}', [BookController::class, 'destroy']);
Route::apiResource('/books', BookController::class)->only(['index', 'show']);

//Route::get('/genres', [GenreController::class, 'index']);
Route::apiResource('/genres', GenreController::class)->only(['index', 'show']);

//Route::get('/authors', [AuthorController::class, 'index']);
//Route::post('/authors', [AuthorController::class, 'store']);
Route::apiResource('/authors', AuthorController::class)->only(['index', 'show']);
