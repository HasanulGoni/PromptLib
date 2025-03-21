<x-app-layout>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <form method="GET" action="{{ route('prompts.savedPrompt') }}">
                        <div class="row">
                            <div class="col-md-5">
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
                                <select name="tags[]" id="tags" class="form-control" multiple>
                                    <option value="">Select Tag(s)</option>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->name }}" {{ in_array($tag->name, request('tags', [])) ? 'selected' : '' }}>
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
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
                            <div class="col-md-1">
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
                        <th>Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prompts as $prompt)
                       
                        <tr onclick="window.location='{{ route('prompts.show', $prompt) }}';" style="cursor: pointer;">
                            <td>{{ $prompt->topic }}</td>
                            <td>
                                <textarea >{{ $prompt->prompt_text }}</textarea>
                                </td>
                            <td>
                                {{ implode(', ', array_column($prompt->toArray()['tags'], 'name')) }}
                            </td>
                            <td>{{ $prompt->category->name ?? 'N/A' }}</td>
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