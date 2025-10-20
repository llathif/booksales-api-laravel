<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PharIo\Manifest\AuthorCollectionIterator;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//Route::get('/books', [BookController::class, 'index']);
//Route::post('/books', [BookController::class, 'store']);
//Route::get('/books/{id}', [BookController::class, 'show']);
//Route::post('/books/{id}', [BookController::class, 'update']);
//Route::delete('/books/{id}', [BookController::class, 'destroy']);
Route::apiResource('/books', BookController::class);

//Route::get('/genres', [GenreController::class, 'index']);
Route::apiResource('/genres', GenreController::class);

//Route::get('/authors', [AuthorController::class, 'index']);
//Route::post('/authors', [AuthorController::class, 'store']);
Route::apiResource('/authors', AuthorController::class);