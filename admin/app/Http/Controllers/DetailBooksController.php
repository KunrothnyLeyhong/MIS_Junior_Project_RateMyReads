<?php

namespace App\Http\Controllers;

use App\Models\ListBooks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DetailBooksController extends Controller
{
    // Show book details
    public function detailbook($id)
{
    $book = ListBooks::findOrFail($id);

    // Only count & average reviews that are visible (hidden = 0)
    $visibleReviewsQuery = $book->reviews()->where('hidden', 0);

    $avgRating = $visibleReviewsQuery->avg('rating') ?? 0;
    $reviewsAndRatingsCount = $visibleReviewsQuery->count();

    // Optional: attach rating to book if you need
    $book->rating = $avgRating;

    return view('book.detailbooks', compact('book', 'avgRating', 'reviewsAndRatingsCount'));
}


    // Handle cover image upload
   public function uploadCover(Request $request, $id)
{
    $request->validate([
        'cloudinaryImageUrl' => 'nullable|url',
    ]);

    $book = ListBooks::findOrFail($id);

    if ($request->filled('cloudinaryImageUrl')) {
        $book->image = $request->cloudinaryImageUrl;
        $book->save();
    }

    return redirect()->back()->with('success', 'Cover image updated successfully.');
}


}
