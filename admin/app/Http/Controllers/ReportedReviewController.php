<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportedReviewController extends Controller
{
    public function reportreview()
    {
        $reports = Report::with(['user', 'reportable'])
            ->where('reportable_type', 'App\Models\Review')
            ->latest()
            ->paginate(3);

        return view('report.reportreview', compact('reports'));
    }

     public function approve($id)
{
    $report = Report::findOrFail($id);
    $report->status = 'approved';
    $report->save();

    $review = $report->reportable;

    if ($review instanceof \App\Models\Review) {
        $review->hidden = 1;
        $review->save();
    }

    return redirect()->route('report.reportreview')->with('success', 'Report approved and review hidden.');
}



    public function reject($id)
{
    $report = Report::findOrFail($id);
    $report->status = 'rejected';
    $report->save();

    $review = $report->reportable;

    if ($review instanceof \App\Models\Review) {
        $review->hidden = 0;
        $review->save();
    }

    return redirect()->route('report.reportreview')->with('success', 'Report rejected.');
}
}
