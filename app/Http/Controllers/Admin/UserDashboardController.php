<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\User;
use App\Models\Prompt;
use App\Models\Category;
use App\Models\Language;

use Illuminate\Http\Request;
use App\Models\ReportedPrompt;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function savedPrompt(Request $request) {
        
        $user = Auth::user();
        // $savedPrompts = $user->savedPrompts()->with('category')->paginate(10);
        $savedPrompts = $user->savedPrompts();
        // Search Functionality
        // Search by keywords
        if ($request->has('keywords') && $request->keywords != '') {
            $savedPrompts->where(function ($subQuery) use ($request) {
                $subQuery->where('prompt_text', 'like', '%' . $request->keywords . '%')
                        ->orWhere('topic', 'like', '%' . $request->keywords . '%');
            });
        }

        // Search by tags
        if ($request->has('tags') && !empty($request->tags)) {
            $savedPrompts->whereHas('tags', function ($subQuery) use ($request) {
                $subQuery->whereIn('name', $request->tags);
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $savedPrompts->where('category_id', $request->category);
        }

        // Filter by language
        if ($request->has('language') && $request->language != '') {
            $savedPrompts->where('language', $request->language);
        }

        // Filter by rating
        if ($request->has('rating') && $request->rating != '') {
            $savedPrompts->where('rating', '>=', $request->rating);
        }

        $prompts = $savedPrompts->with('category','tags')->paginate(10);

        // Fetch additional data for filters
        $categories = Category::all();

        // Fetch Languages
        $languages = Language::all();

        $tags = Tag::all();
        // dd($prompts);
        return view('prompts.savedPrompt', compact('prompts', 'categories','languages', 'tags', 'request'));
    }

    public function reportedPrompt() {
        
        $user = Auth::user();
        $reportedPrompts = $user->reportedPrompts()->paginate(10);
        // dd($prompts->prompt);
        return view('prompts.reportedPrompt', compact('reportedPrompts'));
    }
    

    // Show details of individual prompt
    public function show(Prompt $prompt){
        return view('prompts.show', compact('prompt'));
    }


    // Save a prompt to user's collection
    public function savePrompt(Prompt $prompt)
    {
        // dd($prompt);
        $user = Auth::user();
        $user->savedPrompts()->syncWithoutDetaching([$prompt->id]);

        return back()->with('success', 'Prompt saved successfully.');
    }

    // Remove a saved prompt
    public function removePrompt(Prompt $prompt)
    {
        $user = Auth::user();
        $user->savedPrompts()->detach($prompt->id);

        return back()->with('warning', 'Prompt removed from your collection.');
    }

    // Report a prompt
    public function reportPrompt(Request $request, Prompt $prompt)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        ReportedPrompt::create([
            'user_id' => Auth::id(),
            'prompt_id' => $prompt->id,
            'reason' => $request->reason,
        ]);

        return back()->with('success', 'Prompt reported successfully.');
    }
}
