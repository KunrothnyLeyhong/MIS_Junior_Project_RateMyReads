<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(Request $request)
{
    $user = auth()->user();

    $currentlyReadingCount = $user->library()->where('status', 'current')->count();
    $wantToReadCount = $user->library()->where('status', 'want')->count();
    $readCount = $user->library()->where('status', 'read')->count();

    $reviews = $user->reviews()->with('book')->get();

    $reviewedBooks = $reviews->map(function ($review) {
        return [
            'title' => $review->book->title,
            'author' => $review->book->author,
            'image' => $review->book->image,
            'rating' => $review->rating,
        ];
    });

    $recentActivity = $user->library()->with('book')->orderBy('updated_at', 'desc')->first();

    // Debug ratings array
    $avgRating = \DB::table('reviews')
    ->where('user_id', $user->id)
    ->whereNotNull('rating')
    ->avg('rating');

// dd($avgRating);


    $averageRating = $user->reviews()->avg('rating') ?? 0;

    return view('regUser.profile.profile', [
        'user' => $user,
        'reviewedBooks' => $reviewedBooks,
        'currentlyReadingCount' => $currentlyReadingCount,
        'wantToReadCount' => $wantToReadCount,
        'readCount' => $readCount,
        'recentActivity' => $recentActivity,
        'averageRating' => $averageRating,
        'avgRating' => $avgRating, // Pass the average rating to the view
    ]);
}




    public function edit()
    {
        return view('regUser.profile.edit_profile', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|url',
        ]);

        $user->update($validated);

        return response()->json(['message' => 'Profile updated successfully']);
    }
    

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Old password is incorrect'], 422);
        }

        $user->update([
            'password' => bcrypt($request->new_password),
        ]);

        return response()->json(['message' => 'Password updated successfully']);
    }
}
