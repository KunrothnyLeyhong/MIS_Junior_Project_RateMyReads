<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\LibraryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'G_HomePage'])->name('guestUser.homepage');

// Route::get('/books/search', [BookController::class, 'LiveSearch'])->name('books.search');

// Route::get('/g_books/live-search', [BookController::class, 'liveSearch'])->name('guest.books.live');

Route::get('/about', function () {
    return view('guestUser.about');
});

Route::get('/g_books', [BookController::class, 'G_BookList'])->name('guest.books');

Route::get('/g_book/{id}', [BookController::class, 'G_bookDetails']);

Route::get('/contact', function () {
    return view('guestUser.contact'); // Blade file name
});
Route::post('/contact', [ContactController::class, 'G_store'])->name('contact.G_store');


Auth::routes();



Auth::routes();

Route::middleware(['auth'])->group(function () {
    // Home route
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Dashboard route
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // BookList route
    Route::get('/book', action: [BookController::class, 'index'])->name('book.index'); // For listing books
    Route::get('/api/books', [BookController::class, 'getBookList']);            // For returning JSON data

    // Add book route
    Route::get('/addBook', [BookController::class, 'addBook'])->name('addBook');
    Route::post('/addBook', [BookController::class, 'store']);  // For adding books

    Route::get('/books', [BookController::class, 'show'])->name('book.show');

    // Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');

    // Update book route
    Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('book.edit');
    Route::put('/books/{id}', [BookController::class, 'update'])->name('book.update');

    Route::post('/review/{id}/like', [ReviewController::class, 'toggleLike']);

    Route::get('/review/{review}/comments', [ReviewController::class, 'getComments']);
Route::post('/review/{review}/comments', [ReviewController::class, 'addComment']);

    // Delete book route
    Route::delete('/books/{id}', [BookController::class, 'destroy']);

    // Dashboard data route
    Route::get('/dashboard', [BookController::class, 'getDashboardData']);

    // Fetch single book details
    Route::get('/books/{id}', [BookController::class, 'detail'])->name('books.detail');

    // Show the review page for a specific book
    Route::get('/books/{book}/review', [ReviewController::class, 'index']);
    Route::post('/library/update-status', [LibraryController::class, 'updateStatus']);



    // Submit a review (POST)
    Route::get('/books/{book}/write-review', [ReviewController::class, 'create'])->name('books.writeReview');
    Route::post('/books/{book}/write-review', [ReviewController::class, 'store'])->name('books.storeReview'); 

    // Library route
    Route::get('/library', [BookController::class, 'library'])->name('library');

    Route::get('/library', [LibraryController::class, 'index'])->name('library.index');
Route::get('/library/{status}', [LibraryController::class, 'showStatus'])
    ->name('library.status')
    ->whereIn('status', ['current', 'want', 'read']);

    Route::get('/library/search', [LibraryController::class, 'search'])->name('library.search');


    Route::get('/library/search-live', [LibraryController::class, 'liveSearch'])->name('library.liveSearch');


    // Contact Us routes
    Route::get('/contact_us', [ContactController::class, 'showForm'])->name('contact.form');
    Route::post('/contact_us', [ContactController::class, 'store'])->name('contact.store');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit']);
    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::get('/change_password', fn () => view('regUser.profile.change_password'))->name('change_password');
    Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('update.password');


});