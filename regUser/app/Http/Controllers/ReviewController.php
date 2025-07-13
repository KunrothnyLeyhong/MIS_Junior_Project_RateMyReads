<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\ReviewComment;
class ReviewController extends Controller
{
public function create(Book $book)
{
    return view('regUser.book.review', compact('book'));
}

   public function index($bookId)
{
     $userId = auth()->id();

    $reviews = Review::where('book_id', $bookId)
        ->where('hidden', 0)
        ->whereDoesntHave('reports', function ($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->where('status', 'approved');
        })
        ->with('user')
        ->withCount('likes')
        ->withCount('comments')
        ->get();

    return response()->json($reviews);
}


    public function store(Request $request, Book $book)
{
    $data = $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'required|string|max:1000',
    ]);

    $review = $book->reviews()->create([
        'user_id' => auth()->id(),
        'rating' => $data['rating'],
        'review' => $data['review'],
    ]);

    return response()->json(['message' => 'Review submitted successfully!']);
}

public function toggleLike($id)
{
    $user = auth()->user();

    Log::info("User trying to like review", ['user_id' => $user?->id]);

    $review = Review::findOrFail($id);

    $like = $review->likes()->where('user_id', $user->id)->first();

    if ($like) {
        Log::info("Like exists - deleting", ['like_id' => $like->id]);
        $like->delete();
    } else {
        Log::info("Creating like...");
        $review->likes()->create(['user_id' => $user->id]);
    }

    return response()->json([
        'liked' => !$like,
        'likes_count' => $review->likes()->count()
    ]);
}

public function getComments(Review $review)
{
    return $review->comments()
        ->where('hidden', 0) // only get visible comments
        ->with('user')       // eager load the user who wrote the comment
        ->get();
}


public function addComment(Request $request, Review $review)
{
    $validated = $request->validate([
        'message' => 'required|string|max:1000',
    ]);

    $comment = $review->comments()->create([
        'user_id' => auth()->id(), // or null if guests are allowed
        'message' => $validated['message'],
    ]);

    return response()->json($comment->load('user'), 201);
}



}