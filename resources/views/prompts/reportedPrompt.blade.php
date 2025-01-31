<x-app-layout>
    <div class="container-fluid pt-4 px-4">
      
        <div class="mt-4">
            <table class="table table-striped table-hover table-secondary">
                <thead>
                    <tr>
                        <th>Topic</th>
                        <th>Prompt</th>
                        
                        <th>Category</th>
                        <th>Language</th>
                        <th>Rating</th>
                        <th>Reason</th>
                        <th>Reported On</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reportedPrompts as $report)
                       
                        <tr onclick="window.location='{{ route('prompts.show', $report->prompt) }}';" style="cursor: pointer;">
                            <td>{{ $report->prompt->topic }}</td>
                            <td>
                                <textarea >{{ $report->prompt->prompt_text }}</textarea>
                                </td>
                            
                            <td>{{ $report->prompt->category->name ?? 'N/A' }}</td>
                            <td>{{ $report->prompt->language }}</td>
                            <td>{{ $report->prompt->rating }}</td>
                            <td>
                                {{ $report->reason }}
                            </td>
                            <td>{{ $report->created_at->diffForHumans() }}</td>
                        </tr>
                        
                    @empty
                        <tr>
                            <td colspan="6">No prompts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        
            {{ $reportedPrompts->links() }}
        </div>
    </div>

    
</x-app-layout>