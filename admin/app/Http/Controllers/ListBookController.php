<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListBooks;

class ListBookController extends Controller
{
    // Display list of books with optional search
    public function listbooks(Request $request)
    {
        $search = $request->input('search');

        $books = ListBooks::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                         ->orWhere('genre', 'like', "%{$search}%")
                         ->orWhere('author', 'like', "%{$search}%");
        })->get();

        return view('book.listbooks', compact('books'));
    }

    // Show book details
    public function show($id)
    {
        $book = ListBooks::findOrFail($id);
        return view('book.listbooks', compact('book'));
    }

    // Approve a book
    public function approve(Request $request, $id)
    {
        $book = ListBooks::findOrFail($id);
        $book->status = 'approved';
        $book->save();

        return redirect()->route('book.listbooks')->with('success', 'Book approved successfully.');
    }

    // Delete a book
    public function destroy($id)
    {
        $book = ListBooks::findOrFail($id);
        $book->delete();

        return redirect()->route('book.listbooks')->with('success', 'Book deleted successfully.');
    }
}
