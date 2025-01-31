<?php

namespace App\Http\Controllers\Admin;

use App\Models\Prompt;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Store a new review
    public function store(Request $request, Prompt $prompt)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:500',
        ]);

        // Check if the user has already reviewed the prompt
        $existingReview = Review::where('user_id', Auth::id())
                                ->where('prompt_id', $prompt->id)
                                ->first();

        if ($existingReview) {
            return back()->with('danger','You have already reviewed this prompt! You can modify your review or delete the previous one to leave a new review');
        }

        // Save review
        Review::create([
            'user_id' => Auth::id(),
            'prompt_id' => $prompt->id,
            'rating' => $request->rating,
            'review_text' => $request->review_text,
        ]);

        // Update prompt's average rating
        $prompt->update([
            'rating' => $prompt->reviews()->avg('rating')
        ]);

        return back()->with('success', 'Review submitted successfully.');
    }

    // Delete a review
    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id()) {
            return back()->withErrors(['error' => 'Unauthorized action.']);
        }

        $review->delete();

        // Update prompt's average rating
        $review->prompt->update([
            'rating' => $review->prompt->reviews()->avg('rating')
        ]);

        return back()->with('success', 'Review deleted successfully.');
    }
}
