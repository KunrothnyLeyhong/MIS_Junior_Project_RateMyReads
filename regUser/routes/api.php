<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::middleware('auth:sanctum')->group(function () {
    // Fetch single book details (GET)
    Route::get('/books/{id}', [BookController::class, 'getBook']);

    // Update a book (PUT)
    Route::put('/books/{id}', [BookController::class, 'update']);

    Route::get('/books/{id}', [BookController::class, 'getBookDetailsApi']);

    Route::get('/books/{id}/reviews', [ReviewController::class, 'index']);
;

    // Submit a review (POST)
    Route::post('/books/{id}/reviews', [ReviewController::class, 'store']);

    Route::post('/library', [LibraryController::class, 'store']);

    Route::post('/report', [ReportController::class, 'store']);

});

// Route::get('/books/{id}', [BookController::class, 'getBook']);
// Route::put('/books/{id}', [BookController::class, 'update']);
// Route::delete('/books/{id}', [BookController::class, 'destroy']);
