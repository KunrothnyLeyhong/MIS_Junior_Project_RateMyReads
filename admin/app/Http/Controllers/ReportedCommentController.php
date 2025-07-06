<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportedCommentController extends Controller
{
    /**
     * Display a list of reported comments.
     */
    public function reportcomment()
{
    $reports = Report::with(['user', 'reportable'])
        ->where('reportable_type', 'App\Models\ReviewComment')
        ->latest()
        ->paginate(3); // ✅ Pagination enabled

    return view('report.reportcomment', compact('reports'));
}

public function approve($id)
{
    $report = Report::findOrFail($id);
    $report->status = 'approved';
    $report->save();
    return redirect()->route('report.reportcomment')->with('success', 'Comment approved successfully!');
}

public function reject($id)
{
    $report = Report::findOrFail($id);
    $report->status = 'rejected';
    $report->save();
    return redirect()->route('report.reportcomment')->with('info', 'Comment rejected successfully!');
}

}
