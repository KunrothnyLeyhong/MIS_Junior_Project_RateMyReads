<?php

namespace App\Http\Controllers;

use App\Models\ListBooks;
use App\Models\User;
use App\Models\Report;

class DashboardController extends Controller
{
public function dashboard()
{
    $totalBooks = Listbooks::count();
    $pendingBooks = Listbooks::where('status', 'pending')->count();
    $approvedBooks = Listbooks::where('status', 'approved')->count();
    $totalUsers = User::count();
    $totalReportsComment = Report::where('reportable_type', 'App\Models\ReviewComment')->count();
    $totalReportsReview = Report::where('reportable_type', 'App\Models\Review')->count();

    return view('dashboard', compact(
        'totalBooks',
        'totalUsers',
        'pendingBooks',
        'approvedBooks',
        'totalReportsComment',
        'totalReportsReview'
    ));
}
}