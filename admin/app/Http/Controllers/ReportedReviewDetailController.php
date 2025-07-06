<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportedReviewDetailController extends Controller
{
    public function show($id)
    {
        $report = Report::with([
            'reportable.user',
            'reportable.book'
        ])->findOrFail($id);

        return view('report.reportreviewdetail', compact('report'));
    }

    public function approve($id)
    {
        $report = Report::findOrFail($id);
        $report->status = 'approved';  // or 1 if using integers
        $report->save();

        return redirect()->route('report.reportreview')->with('success', 'Reported review approved successfully.');
    }

    public function reject($id)
    {
        $report = Report::findOrFail($id);
        $report->status = 'rejected';  // or 2 if using integers
        $report->save();

        return redirect()->route('report.reportreview')->with('success', 'Reported review rejected.');
    }
}
