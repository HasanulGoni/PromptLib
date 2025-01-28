<x-app-layout>
    <div class="container-fluid pt-4 px-4">
        <div class="row">
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <div class="navbar">
                        <h6>Prompts</h6>
                        <div class="navbar">
                            <a href="{{ route('admin.prompts.create') }}" type="button" class="btn btn-info m-2">Create</a>
                        <a href="{{ route('admin.prompts.upload.create') }}" type="button" class="btn btn-info">CSV Upload</a>
                        </div>
                        
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Topic</th>
                                    <th scope="col">Prompt Text</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Rating</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prompts as $prompt)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $prompt->topic }}</td>
                                    <td>{{ $prompt->prompt_text }}</td>
                                    <td>{{ $prompt->category->name }}</td>
                                    <td>{{ $prompt->rating }}</td>
                                    <td>{{ $prompt->status }}</td>
                                    <td class="navbar justify-content-start">
                                        <a href="{{ route('admin.prompts.edit', $prompt)}}" type="button" class="btn btn-light">Edit</a> 
                                        <a href="{{ route('admin.prompts.show', $prompt)}}" type="button" class="btn btn-success m-1">View</a>
                                        <form method="POST" action="{{ route('admin.prompts.destroy', $prompt)}}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-primary">Delete</button>
                                        </form>
                                        </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    
        </div>
    </div>

</x-app-layout>
    