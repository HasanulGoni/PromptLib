<x-app-layout>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <form method="GET" action="{{ route('prompts.search') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" name="keywords" class="form-control" placeholder="Search by keywords" value="{{ request('keywords') }}">
                            </div>
                            <div class="col-md-2">
                                <select name="category" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="language" class="form-control">
                                    <option value="">Select Language</option>
                                    @foreach ($languages as $lang)
                                        <option value="{{ $lang->language_name }}" {{ request('language') == $lang->language_name ? 'selected' : '' }}>{{ $lang->language_name }}</option>
                                    @endforeach
                                    <!-- Add other languages -->
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="sort_by" class="form-control">
                                    <option value="">Sort By</option>
                                    <option value="popular" {{ request('sort_by') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                                    <option value="highest_rated" {{ request('sort_by') == 'highest_rated' ? 'selected' : '' }}>Highest Rated</option>
                                    <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Newest</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

        
        <div class="mt-4">
            <table class="table table-striped table-hover table-secondary">
                <thead>
                    <tr>
                        <th>Topic</th>
                        <th>Prompt</th>
                        <th>Tags</th>
                        <th>Category</th>
                        <th>Language</th>
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prompts as $prompt)
                        <tr>
                            <td>{{ $prompt->topic }}</td>
                            <td>{{ $prompt->prompt_text }}</td>
                            <td>{{ $prompt->tags }}</td>
                            <td>{{ $prompt->category->name ?? 'N/A' }}</td>
                            <td>{{ $prompt->language }}</td>
                            <td>{{ $prompt->rating }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No prompts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        
            {{ $prompts->links() }}
        </div>
    </div>

    
</x-app-layout>