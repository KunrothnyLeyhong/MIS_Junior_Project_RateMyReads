<?php
namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class LibraryController extends Controller
{
    // Define status constants to avoid typos
    const STATUS_CURRENT = 'current';
    const STATUS_WANT = 'want';
    const STATUS_READ = 'read';


    // Show the library page with user-specific books grouped by status
    public function index()
    {
        $userId = auth()->id();

        // Eager load libraries filtered by current user to avoid N+1 problem
        $books = Book::with([
            'libraries' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }
        ])
            ->whereHas('libraries', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->where('status', 'approved')  // only approved books
            ->get();


        // Attach status from the pivot to each book
        foreach ($books as $book) {
            $libraryEntry = $book->libraries->first();
            $book->status = $libraryEntry ? $libraryEntry->status : null;
        }

        // Get book IDs for rating query
        $bookIds = $books->pluck('id')->toArray();

        // Fetch average ratings per book
        $ratings = Review::whereIn('book_id', $bookIds)
            ->where('hidden', 0)
            ->select('book_id', \DB::raw('AVG(rating) as avg_rating'))
            ->groupBy('book_id')
            ->pluck('avg_rating', 'book_id');


        return view('regUser.library.library', compact('books', 'ratings'));
    }

    // Store or update library entry
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'status' => ['required', 'string', Rule::in([self::STATUS_CURRENT, self::STATUS_WANT, self::STATUS_READ])],
        ]);

        $userId = auth()->id();

        $libraryEntry = Library::updateOrCreate(
            ['user_id' => $userId, 'book_id' => $request->book_id],
            ['status' => $request->status]
        );

        return response()->json([
            'message' => 'Book saved to library',
            'library' => $libraryEntry,
        ]);
    }

    // Show books by specific status
    public function showStatus(Request $request, $status)
    {
        if (!in_array($status, ['current', 'want', 'read'])) {
            abort(404);
        }

        $userId = auth()->id();
        $search = $request->input('search', '');

        $query = Library::with([
    'book' => function ($query) {
        $query->withAvg(['reviews as reviews_avg_rating' => function ($q) {
            $q->where('hidden', 0);
        }], 'rating')
        ->where('status', 'approved');  // only approved books
    }
])

            ->whereHas('book', function ($q) {
                $q->where('status', 'approved');  // IMPORTANT: Only libraries with approved books
            })
            ->where('status', $status)
            ->where('user_id', $userId);



        if ($search) {
            $query->whereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $libraryEntries = $query->get();

        $initialBooks = $libraryEntries->filter(function ($library) {
            return $library->book !== null;
        })->map(function ($library) {
            return [
                'id' => $library->id,
                'book_id' => $library->book_id,
                'created_at' => $library->created_at->toDateTimeString(),
                'avg_rating' => $library->book->reviews_avg_rating ?? 0,
                'book' => [
                    'id' => $library->book->id,
                    'title' => $library->book->title,
                    'author' => $library->book->author,
                    'image' => $library->book->image,
                    'genre' => $library->book->genre,
                ],
            ];
        });


        return view('regUser.library.libraryStatus', [
            'initialBooks' => $initialBooks,
            'status' => $status,
        ]);
    }



    public function liveSearch(Request $request)
{
    try {
        $search = trim($request->input('q'));
        $status = $request->input('status');

        $libraries = Library::with([
            'book' => function ($query) {
                $query->withAvg(['reviews as reviews_avg_rating' => function ($q) {
                    $q->where('hidden', 0);
                }], 'rating')->where('status', 'approved');
            }
        ])
        ->when($status, function ($builder) use ($status) {
            $builder->where('status', $status);
        })
        ->when($search, function ($builder) use ($search) {
            $builder->whereHas('book', function ($q) use ($search) {
                $q->where(function ($subQ) use ($search) {
                    $subQ->where('title', 'like', '%' . $search . '%')
                         ->orWhere('author', 'like', '%' . $search . '%')
                         ->orWhere('genre', 'like', '%' . $search . '%');
                });
            });
        })
        ->get()
        ->map(function ($library) {
            return [
                'id' => $library->id,
                'book_id' => $library->book_id,
                'created_at' => $library->created_at->toDateTimeString(),
                'avg_rating' => $library->book->reviews_avg_rating ?? 0,
                'book' => [
                    'id' => $library->book->id,
                    'title' => $library->book->title,
                    'author' => $library->book->author,
                    'image' => $library->book->image,
                    'genre' => $library->book->genre,
                ],
            ];
        });

        return response()->json($libraries);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

    public function updateStatus(Request $request)
    {
        $request->validate([
            'book_id' => 'required|integer|exists:books,id',
            'status' => 'required|in:current,want,read',
        ]);

        $user = auth()->user();
        $libraryEntry = $user->library()->where('book_id', $request->book_id)->first();

        if (!$libraryEntry) {
            return response()->json(['success' => false, 'message' => 'Book not found in user library']);
        }

        $libraryEntry->status = $request->status;
        $libraryEntry->save();

        return response()->json(['success' => true]);
    }

















}