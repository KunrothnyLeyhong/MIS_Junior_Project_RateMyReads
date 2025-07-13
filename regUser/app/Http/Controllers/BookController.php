<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Models\Review;
use App\Http\Controllers\ReviewController; // Assuming you have a ReviewController for handling reviews

class BookController extends Controller
{


//Guest User 
public function G_BookList(Request $request)
{
    $query = Book::where('status', 'approved');

    // Search
    if ($request->has('search') && !empty($request->search)) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhere('author', 'like', '%' . $search . '%')
              ->orWhere('genre', 'like', '%' . $search . '%');
        });
    }

    // Genre filter
    if ($request->has('genre') && !empty($request->genre)) {
        $query->where('genre', 'like', '%' . $request->genre . '%');
    }

    // Paginate & keep query params in pagination links
    $books = $query->paginate(9)->withQueryString();

    // Fixed 15 genres list
    $genres = ['Romance', 'Fiction', 'Non-fiction', 'Mystery', 'Fantasy', 'Sci-Fi', 'Historical', 'Thriller', 'Horror', 'Young Adult', "Children's", 'Biography/Memoir', 'Self-Help', 'Poetry', 'Graphic Novels', 'Others'];

    return view('guestUser.book_list', compact('books', 'genres'));
}




    public function G_BookDetails($id)
{
    $book = Book::with(['reviews' => function ($query) {
        $query->where('hidden', 0)->with('user');
    }])->findOrFail($id);

    return view('guestUser.book_details', compact('book'));
}




    //Registered User
    public function getDashboardData()
    {
        $user = auth()->user();

        // Count all books for the user
        $totalBooks = Book::where('publisher_id', $user->id)->count();

        // Count pending books
        $pendingBooks = Book::where('publisher_id', $user->id)
            ->where('status', 'pending')
            ->count();

        // Count approved books
        $acceptedBooks = Book::where('publisher_id', $user->id)
            ->where('status', 'approved')
            ->count();

        return view('regUser.book.Dashboard', [
            'totalBooks' => $totalBooks,
            'pendingBooks' => $pendingBooks,
            'acceptedBooks' => $acceptedBooks,
        ]);
    }



    // Show the form to add a book
    public function index()
    {
        return view('regUser.book.bookList');
    }

    public function getBookList(Request $request)
{
    $query = Book::where('status', 'approved');          // ✅ Only approved books

    // 🔍 Flexible keyword search (even 1‑letter terms)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $like = "%{$search}%";                       // match anywhere in the text
            $q->where('title',  'LIKE', $like)
              ->orWhere('author','LIKE', $like);
        });
    }

    // 🎯 Genre filter
    if ($request->filled('genres')) {
        $genres = explode(',', $request->genres);
        $query->whereIn('genre', $genres);
    }

    // 📚 Paginate (9 per page)
    $books = $query->paginate(9);

    // ⭐ Add average rating
    $books->getCollection()->transform(function ($book) {
        $book->averageRating = round(
            Review::where('book_id', $book->id)->avg('rating'),
            1
        );
        return $book;
    });

    return response()->json($books);
}




    public function addBook()
    {
        return view('regUser.book.addBook');
    }

    // Store a new book
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'pages' => 'required|integer',
            'published_date' => 'required|date',
            'description' => 'required|string',
            'cloudinaryImageUrl' => 'nullable|string',
        ]);

        $book = new Book();
        $book->title = $request->title;
        $book->author = $request->author;
        $book->genre = $request->genre;
        $book->pages = $request->pages;
        $book->published_date = $request->published_date;
        $book->description = $request->description;
        $book->publisher_id = auth()->user()->id;
        $book->status = 'pending'; // Default status, can be changed later

        if ($request->has('cloudinaryImageUrl')) {
            $book->image = $request->cloudinaryImageUrl;
        }

        $book->save();

        return response()->json(['message' => 'Book added successfully!'], 201);
    }


    // Display books, optionally filtered by search
    public function show(Request $request)
{
    $user = auth()->user();

    $query = Book::where('status', 'approved')
                 ->where('publisher_id', $user->id); // Use publisher_id here

    if ($search = $request->query('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%$search%")
              ->orWhere('genre', 'like', "%$search%")
              ->orWhere('author', 'like', "%$search%");
        });
    }

    $books = $query->paginate(9);

    if ($request->wantsJson()) {
        return response()->json($books);
    }

    return view('regUser.book.viewBookPage', compact('books'));
}


    public function detail($id)
    {
        // Load the book and its publisher (if any)
        $book = Book::with('publisher')->findOrFail($id);
        $book = Book::findOrFail($id);


        // // Get some recommended books excluding the current one
        // $recommendedBooks = Book::where('id', '!=', $book->id)->take(4)->get();

        return view('regUser.book.bookDetail', [
            'book' => $book,
            // 'recommendedBooks' => $recommendedBooks,
            'genres' => $book->genre, // Assuming you have a genres relationship
        ]);
    }

    public function getBookDetailsApi($id)
    {
        $book = Book::with('publisher')->findOrFail($id);
        return response()->json($book);
    }



    public function getBook($id)
    {
        // Fetch the book by its ID
        $book = Book::findOrFail($id);

        // Check if the authenticated user is the publisher of the book
        if ($book->publisher_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($book);
    }




    // Show a single book for editing (used in Vue or Blade)
    public function edit($id)
    {
        $book = Book::findOrFail($id);

        // Ensure the authenticated user owns the book
        if ($book->publisher_id !== auth()->id()) {
            return redirect()->route('book.index')->with('error', 'Unauthorized action.');
        }

        // Pass the book data to the Blade view
        return view('regUser.book.updateBook', ['bookId' => $id, 'book' => $book]);
    }





    public function update(Request $request, $id)
    {
        // Debug: check user and request data
        \Log::info('User:', ['id' => auth()->id()]);
        \Log::info('Request data:', $request->all());

        $book = Book::findOrFail($id);

        $book->title = $request->input('title');
        $book->author = $request->input('author');
        $book->genre = $request->input('genre');
        $book->pages = $request->input('pages');
        $book->published_date = $request->input('published_date');
        $book->description = $request->input('description');
        $book->image = $request->input('image');

        $book->save();

        return response()->json(['message' => 'Book updated successfully']);
    }







    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);

            // Optional: delete image if stored on Cloudinary or locally
            if ($book->image_url) {
                // Delete from Cloudinary if needed
                Cloudinary::destroy($book->public_id); // only if you store public_id
            }

            $book->delete();

            return response()->json(['message' => 'Book deleted successfully']);
        } catch (\Exception $e) {
            \Log::error('Delete Error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete book'], 500);
        }
    }




    public function library()
    {
        $userId = auth()->id();

        $books = Book::where('publisher_id', $userId)->get()->groupBy('status');

        $sections = [
            'current' => 'Currently Reading',
            'finished' => 'Finished Reading',
            'wishlist' => 'Want to Read',
        ];

        return view('regUser.library.library', compact('books', 'sections'));
    }




}
