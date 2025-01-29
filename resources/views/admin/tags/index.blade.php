<x-app-layout>
    <div class="container-fluid pt-4 px-4">
        <div class="row">
            <div class="col-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <div class="navbar">
                        <h6>Tags</h6>
                        <a href="{{ route('admin.tags.create') }}" type="button" class="btn btn-info rounded-pill m-2">Create</a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tags as $tag)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $tag->name }}</td>
                                    <td class="navbar justify-content-start">
                                        <a href="{{ route('admin.tags.edit', $tag)}}" type="button" class="btn btn-light">Edit</a> 
                                        <a href="{{ route('admin.tags.show', $tag)}}" type="button" class="btn btn-success m-1">View</a>
                                        <form method="POST" action="{{ route('admin.tags.destroy', $tag)}}">
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
    