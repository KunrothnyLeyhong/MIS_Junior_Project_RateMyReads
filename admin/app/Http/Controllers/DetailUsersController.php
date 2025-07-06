<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DetailUsersController extends Controller
{
   public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.detailuser', compact('user'));  // adjust view path if needed
    }

    public function addBook($id)
    {
        $user = User::with('books')->findOrFail($id);
        // Logic for loading a form or redirecting for book-adding
        return view('user.addbook', compact('user')); // You can create this view or adjust route as needed
    }

}
