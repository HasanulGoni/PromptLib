<x-app-layout>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">Create New Prompt</h6>
                    <form method="POST" action="{{ route('admin.prompts.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="topic" class="form-label">Topic</label>
                            <input type="text" class="form-control" id="topic" name="topic">
                        </div>
                        <div class="mb-3">
                            <label for="prompt_text" class="form-label">Prompt Copy</label>
                            <textarea class="form-control" placeholder="Write The Prompt Here ..."
                                    id="prompt_text" name="prompt_text" style="height: 150px;"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <select name="tags[]" id="tags" class="form-select mb-3" multiple>
                                @if(isset($tags)) {{-- Use this if you're passing existing tags for edit --}}
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->name }}" 
                                            >
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Category</label>
                            <select class="form-select mb-3" name="category_id">
                                <option selected>Choose A Category</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select mb-3" name="status">
                                <option selected>Select Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="under_review">Under Review</option>
                                
                            </select>

                        </div>
                        
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
