<x-app-layout>
    <div class="container-fluid pt-4 px-4">
        <div class="bg-secondary rounded h-100 p-4">
            <h2 class="mb-2">Prompt Details</h2>
            <p>
                <span class="fw-bolder text-danger">Topic:</span> {{ $prompt->topic }}
            </p>
            <p>
                <span class="fw-bolder text-danger">Category:</span> {{ $prompt->category->name }}
            </p>
            <p>
                <span class="fw-bolder text-danger">Tags:</span> {{ $prompt->tags->pluck('name')->implode(', ') }}
            </p>

            <p>
                <span class="fw-bolder text-danger">Rating:</span> 
            </p>
            <p>
                <span class="fw-bolder text-danger">Favourite:</span> 
            </p>

            <div>
                <div class="navbar">
                    <h6>Prompt Text</h6>
                      
                        @if(auth()->user()->savedPrompts()->where('prompt_id', $prompt->id)->exists())
                        <form action="{{ route('prompts.remove', $prompt)}}" method="post">
                            @csrf
                            <button class="btn btn-danger">Unsave</button>
                        </form>
                            
                        @else
                         
                        <form action="{{ route('prompts.save', $prompt)}}" method="post">
                            @csrf
                            <button class="btn btn-outline-info">Save</button>
                        </form>
                        @endif
                    

                </div>
                <div>
                    <textarea name="" id="" class="form-control bg-white">{{ $prompt->prompt_text }}
                    </textarea>
                    <div class="mt-4">

                        <p class="fw-bolder text-warning mb-2">Report this prompt</p>
                        <form method="POST" action="{{ route('prompts.report', $prompt)}}">
                            @csrf
                            <label for="reason">Reason*</label>
                            <textarea name="reason" id="reason" class="form-control" placeholder="Why you are going to report this prompt?" required></textarea>
                            <button type="submit" class="btn btn-outline-warning m-2">Submit</button>
                        </form>
                        
                    </div>
                    
                </div>
                
            </div>
        </div>
        
        
    </div>

    
</x-app-layout>