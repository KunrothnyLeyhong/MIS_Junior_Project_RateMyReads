<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Guest User
    public function G_Homepage()
    {
        // Fetch top 10 books based on average rating
        $books = Book::with('reviews')
            ->where('status', 'approved')
            ->get()
            ->sortByDesc(function ($book) {
                return $book->reviews->avg('rating');
            })
            ->take(5);

        return view('guestUser.homepage', compact('books'));
    }


    // Registered User
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        $currentlyReading = $user->library()->where('status', 'current')->count();
        $wantToRead = $user->library()->where('status', 'want')->count();
        $readBooks = $user->library()->where('status', 'read')->count();

        $recentActivity = $user->library()->with('book')->orderBy('updated_at', 'desc')->first();

        $averageRating = null;
        if ($recentActivity && $recentActivity->book) {
            $averageRating = Review::where('book_id', $recentActivity->book->id)->avg('rating');
        }
        // Fetch the latest review with the book and user info (for recent review box)
        $recentReview = Review::with(['book', 'user'])
    ->where('user_id', auth()->id()) // ✅ Filter by current user
    ->orderBy('created_at', 'desc')
    ->first();


        return view('regUser.home', [
            'user' => $user,
            'currentlyReading' => $currentlyReading,
            'wantToRead' => $wantToRead,
            'readBooks' => $readBooks,
            'recentActivity' => $recentActivity ? $recentActivity->toJson() : null,
            'averageRating' => $averageRating,
            'recentReview' => $recentReview ? $recentReview->toJson() : null,
        ]);
    }

}
