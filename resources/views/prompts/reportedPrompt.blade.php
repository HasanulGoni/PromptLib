<x-app-layout>
    <div class="container-fluid pt-4 px-4">
      
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
                       
                        <tr onclick="window.location='{{ route('prompts.show', $prompt) }}';" style="cursor: pointer;">
                            <td>{{ $prompt->topic }}</td>
                            <td>
                                <textarea >{{ $prompt->prompt_text }}</textarea>
                                </td>
                            <td>
                                {{ implode(', ', array_column($prompt->toArray()['tags'], 'name')) }}
                            </td>
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