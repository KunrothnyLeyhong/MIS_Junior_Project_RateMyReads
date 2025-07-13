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
