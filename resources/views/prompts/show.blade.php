<x-app-layout>
    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/rating.css') }}">
@endpush
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
                <span class="fw-bolder text-danger">
                    Rating 
                    <span class="text-white-50"> ({{ $prompt->reviews->count() }}) </span>:</span>
                    <span> {{ $prompt->rating }}/5 </span> 

                    <span class="star-rating">
                        <span style="width: {{ $prompt->rating * 20 }}%;">★★★★★</span>
                    </span>
                </span>
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
                    
                    {{-- Review --}}
                    <div class="mt-4">
                        <h6>Submit Your Review</h6>
                        <form class="mb-2" action="{{ route('prompts.review', $prompt->id) }}" method="POST">
                            @csrf
                            <div class="form-group mb-2">
                                <label>Rating:</label>
                                <select name="rating" class="form-control">
                                    <option value="5">⭐⭐⭐⭐⭐</option>
                                    <option value="4">⭐⭐⭐⭐</option>
                                    <option value="3">⭐⭐⭐</option>
                                    <option value="2">⭐⭐</option>
                                    <option value="1">⭐</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label>Review:</label>
                                <textarea name="review_text" class="form-control" placeholder="Write your review..."></textarea>
                            </div>
                            <div class="form-group mb-2">
                                <button type="submit" class="btn btn-primary">Submit Review</button>
                            </div>
                            
                        </form>

                        <h5>Reviews</h5>
                        @foreach ($prompt->reviews as $review)
                            <div class="review">
                                <p><strong>{{ $review->user->name }}</strong> - Rated: {{ $review->rating }} ⭐</p>
                                <p>{{ $review->review_text }}</p>
                                @if(auth()->id() === $review->user_id)
                                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete Review</button>
                                    </form>
                                @endif
                            </div>
                        @endforeach

                    </div>

                    {{-- Report --}}
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