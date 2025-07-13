<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\ReviewComment;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:review,comment',
            'id' => 'required|integer',
            'reason' => 'required|string|max:255',
            // Optionally allow passing a status or default to "pending"
            'status' => 'nullable|in:pending,resolved,rejected',
        ]);

        // Determine the reportable model
        $reportable = null;
        if ($request->type === 'review') {
            $reportable = Review::findOrFail($request->id);
        } elseif ($request->type === 'comment') {
            $reportable = ReviewComment::findOrFail($request->id);
        }

        // Prevent duplicate report by same user
        $existing = $reportable->reports()->where('user_id', auth()->id())->first();
        if ($existing) {
            return response()->json(['message' => 'You already reported this.'], 409);
        }

        // Save report with status (default to "pending")
        $reportable->reports()->create([
            'user_id' => auth()->id(),
            'reason' => $request->reason,
            'status' => $request->status ?? 'pending',
        ]);

        return response()->json(['message' => 'Report submitted successfully.']);
    }
}
