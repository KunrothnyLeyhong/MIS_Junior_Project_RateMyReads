<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportedCmtDetailController extends Controller
{
    public function show($id)
    {
        // Eager load reportable comment + user + review + book
        $report = Report::with([
            'reportable.user',
            'reportable.review.book'
        ])->findOrFail($id);

        return view('report.reportcommentdetail', compact('report'));
    }

    public function approve($id)
    {
        $report = Report::findOrFail($id);
        $report->status = 'approved';
        $report->save();

        return redirect()->route('report.reportcomment')->with('success', 'Comment approved successfully.');
    }

    public function reject($id)
    {
        $report = Report::findOrFail($id);
        $report->status = 'rejected';
        $report->save();

        return redirect()->route('report.reportcomment')->with('success', 'Comment rejected successfully.');
    }
}
