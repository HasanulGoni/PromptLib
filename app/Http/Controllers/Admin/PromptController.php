<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use App\Models\Prompt;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


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
        return view('admin.prompts.create', compact('categories','languages'));
    }
    // Store a new prompt
    public function store(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'prompt_text' => 'required|string',
            'tags' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'language' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,under_review',
        ]);

        Prompt::create($request->all());

        return redirect()->route('admin.prompts.index')->with('success', 'Prompt created successfully.');
    }

    // Show form to edit an existing prompt
    public function edit(Prompt $prompt)
    {
        $categories = Category::all();
        $languages = Language::all();
        return view('admin.prompts.edit', compact('prompt', 'categories','languages'));
    }

    // Show an existing prompt
    public function show(Prompt $prompt)
    {
        // dd($prompt->category->name);
        $categories = Category::all();
        $languages = Language::all();
        return view('admin.prompts.show', compact('prompt', 'categories','languages'));
    }

    // Update an existing prompt
    public function update(Request $request, Prompt $prompt)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'prompt_text' => 'required|string',
            'tags' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'language' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,under_review',
        ]);

        $prompt->update($request->all());

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

            // Add to batch insert array
            $prompts[] = [
                'topic' => $row['topic'],
                'prompt_text' => $row['prompt'],
                'tags' => $row['tags'],
                'category_id' => $this->getCategoryId($row['category']), // Get or create category
                'language' => $row['language'],
                'status' => $row['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert prompts in bulk
        Prompt::insert($prompts);

        return redirect()->back()->with('success', count($prompts) . ' prompts uploaded successfully.');
    }

    private function getCategoryId($categoryName)
    {
        $category = Category::firstOrCreate(['name' => $categoryName]);
        return $category->id;
    }

    public function search(Request $request)
    {
        // Get filters from the request
        $query = Prompt::query();

        if ($request->has('keywords') && $request->keywords != '') {
            $query->where('prompt_text', 'like', '%' . $request->keywords . '%')
                  ->orWhere('topic', 'like', '%' . $request->keywords . '%')
                  ->orWhere('tags', 'like', '%' . $request->keywords . '%');
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('language') && $request->language != '') {
            $query->where('language', $request->language);
        }

        if ($request->has('rating') && $request->rating != '') {
            $query->where('rating', '>=', $request->rating);
        }

        if ($request->has('sort_by') && $request->sort_by != '') {
            switch ($request->sort_by) {
                case 'popular':
                    $query->orderBy('usage_count', 'desc'); // Assume usage_count tracks popularity
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
        $prompts = $query->with('category')->paginate(10);

        // Fetch additional data for filters
        $categories = Category::all();

        return view('prompts.search', compact('prompts', 'categories', 'request'));
    }
}
