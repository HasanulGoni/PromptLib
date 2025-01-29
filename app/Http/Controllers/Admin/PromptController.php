<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Prompt;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class PromptController extends Controller
{
    public function index(){
        $prompts = Prompt::query()->get();
        return view('admin.prompts.index', compact('prompts'));
    }

    public function uploadCSVcreateForm(){
        return view('admin.prompts.uploadCSVcreateForm');
    }

    // Show form to create a new prompt
    public function create()
    {
        $categories = Category::all();
        $languages = Language::all();
        $tags = Tag::all();
        return view('admin.prompts.create', compact('categories','languages','tags'));
    }
    // Store a new prompt
    public function store(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'prompt_text' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:255',
            'category_id' => 'required|exists:categories,id',
            'language' => 'nullable|string|max:255|exists:languages,language_name',
            'status' => 'required|in:active,inactive,under_review',
        ]);

        $prompt = Prompt::create($request->except('tags'));
        // Prompt::create($request->all());

        if ($request->has('tags')) {
            $tagIds = $this->syncTags($request->tags);
            $prompt->tags()->sync($tagIds);
        }

        return redirect()->route('admin.prompts.index')->with('success', 'Prompt created successfully.');
    }

    // Show form to edit an existing prompt
    public function edit(Prompt $prompt)
    {
        $categories = Category::all();
        $languages = Language::all();
        $tags = Tag::all();
        $prompt->load('tags');
        // dd($prompt->toArray()['tags']);
        return view('admin.prompts.edit', compact('prompt', 'categories','languages','tags'));
    }

    // Show an existing prompt
    public function show(Prompt $prompt)
    {
        // dd($prompt->category->name);
        $categories = Category::all();
        $languages = Language::all();
        $tags = Tag::all();
        $prompt->load('tags');
        return view('admin.prompts.show', compact('prompt', 'categories','languages', 'tags'));
    }

    // Update an existing prompt
    public function update(Request $request, Prompt $prompt)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'prompt_text' => 'required|string',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:255',
            'category_id' => 'required|exists:categories,id',
            'language' => 'nullable|string|max:255|exists:languages,language_name',
            'status' => 'required|in:active,inactive,under_review',
        ]);

        $prompt->update($request->except('tags'));

        if ($request->has('tags')) {
            $tagIds = $this->syncTags($request->tags);
            $prompt->tags()->sync($tagIds);
        }

        return redirect()->route('admin.prompts.index')->with('success', 'Prompt updated successfully.');
    }

    // Delete a prompt
    public function destroy(Prompt $prompt)
    {
        $prompt->delete();

        return redirect()->route('admin.prompts.index')->with('success', 'Prompt deleted successfully.');
    }

    public function uploadCSV(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        // Read the uploaded file
        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        // Open and parse the CSV
        $csvData = array_map('str_getcsv', file($path));
        $headers = array_map('strtolower', array_shift($csvData)); // Extract headers

        // Validate headers (optional)
        $requiredHeaders = ['topic', 'prompt', 'tags', 'category', 'language', 'status'];
        if (array_diff($requiredHeaders, $headers)) {
            return redirect()->back()->withErrors(['error' => 'Invalid CSV headers.']);
        }

        // Process each row
        $prompts = [];
        $insertCount = 0;
        foreach ($csvData as $row) {
            $row = array_combine($headers, $row); // Map headers to values
            $validator = Validator::make($row, [
                'topic' => 'required|string|max:255',
                'prompt' => 'required|string',
                'tags' => 'nullable|string',
                'category' => 'required|string|max:255',
                'language' => 'nullable|string|max:255|exists:languages,language_name',
                'status' => 'required|in:active,inactive,under_review',
            ]);

            if ($validator->fails()) {
                // Skip invalid rows (you can also log or display errors if needed)
                continue;
            }

            // Get or create category
            $categoryId = $this->getCategoryId($row['category']);

            // Create the prompt
            $prompt = Prompt::create([
                'topic' => $row['topic'],
                'prompt_text' => $row['prompt'],
                'category_id' => $categoryId,
                'language' => $row['language'],
                'status' => $row['status'],
            ]);
            $insertCount++;
                    // Sync tags
            if (!empty($row['tags'])) {
                $tagIds = $this->syncTags(explode(',', $row['tags']));
                $prompt->tags()->sync($tagIds);
            }
        }

        // Insert prompts in bulk
        // Prompt::insert($prompts);

        return redirect()->back()->with('success', $insertCount . ' prompts uploaded successfully.');
    }

    private function getCategoryId($categoryName)
    {
        $category = Category::firstOrCreate(['name' => $categoryName]);
        return $category->id;
    }


    // New search for proper filter
    public function search(Request $request)
    {
        // Initialize the query
        $query = Prompt::query();

        // Search by keywords
        if ($request->has('keywords') && $request->keywords != '') {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->where('prompt_text', 'like', '%' . $request->keywords . '%')
                        ->orWhere('topic', 'like', '%' . $request->keywords . '%')
                        ->orWhere('tags', 'like', '%' . $request->keywords . '%');
            });
        }

        // Search by tags
        if ($request->has('tags') && !empty($request->tags)) {
            $query->whereHas('tags', function ($subQuery) use ($request) {
                $subQuery->whereIn('name', $request->tags);
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Filter by language
        if ($request->has('language') && $request->language != '') {
            $query->where('language', $request->language);
        }

        // Filter by rating
        if ($request->has('rating') && $request->rating != '') {
            $query->where('rating', '>=', $request->rating);
        }

        // Sort by user selection
        if ($request->has('sort_by') && $request->sort_by != '') {
            switch ($request->sort_by) {
                case 'popular':
                    $query->orderBy('usage_count', 'desc'); // Assuming usage_count tracks popularity
                    break;
                case 'highest_rated':
                    $query->orderBy('rating', 'desc');
                    break;
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        // Paginate results
        $prompts = $query->with('category','tags')->paginate(10);
        // dd($prompts[0]->relations);
        // dd($prompts[0]->toArray()['tags']);
        // Fetch additional data for filters
        $categories = Category::all();

        // Fetch Languages
        $languages = Language::all();

        $tags = Tag::all();
        // Pass the original request to retain filter selections
        return view('prompts.search', compact('prompts', 'categories','languages', 'tags', 'request'));
    }

    // Helper Method for Syncing Tags
    private function syncTags($tags)
    {
        return collect($tags)->map(function ($tagName) {
            return Tag::firstOrCreate(['name' => $tagName])->id;
        });
    }
}
