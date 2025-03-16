<x-app-layout>
    @push('styles')
    <link rel="stylesheet" href="{{ asset('css/rating.css') }}">
    @endpush

    @push('script')
        <script src="{{ asset('js/prompts/show.js')}}"></script>
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
                        <button class="btn btn-light" id="copyButton">Copy</button>
                </div>
                <div>
                    <form action="{{ route('prompts.sendToAI') }}" method="POST" class="mb-4" id="sendToAIForm">
                        @csrf
                    <label class="text-info" for="custom_prompt">You Can The Customize Prompt Before Send To AI (Optional):</label>
                    
                    <textarea name="custom_prompt" id="custom_prompt" class="form-control bg-white">{{ $prompt->prompt_text }} </textarea>
                    
                    </form>
                    {{-- Send To AI Model --}}
                   <div class="d-flex">
                        <div>
                            <button type="submit" class="btn btn-primary" id="sendToAIBtn">Send to AI</button>
                        </div>
                        <div class="mx-1">
                            @if(auth()->user()->savedPrompts()->where('prompt_id', $prompt->id)->exists())
                            <form action="{{ route('prompts.remove', $prompt)}}" method="post">
                                @csrf
                                <button class="btn btn-danger">Unsave</button>
                            </form>
                                
                            @else
                            
                            <form action="{{ route('prompts.save', $prompt)}}" method="post">
                                @csrf
                                <button class="btn btn-info">Save</button>
                            </form>
                            @endif
                        </div>
                        <div>
                           
                            <button class="btn btn-warning" id="translateBtn">Translate</button>
                           
                        </div>
                   </div>

                    @if (session('ai_response'))
                        <h5>AI Response:</h5>
                        <pre><p id="ai-response" style="white-space: pre-wrap; word-wrap: break-word; overflow-wrap: break-word;">{{ session('ai_response') }}</p></pre>

                        <button class="btn btn-danger mt-2" onclick="downloadFile('pdf')">Download as PDF</button>
                        <button class="btn btn-primary mt-2" onclick="downloadFile('doc')">Download as DOC</button>
                    
                    @endif


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
    @push('script')
        <script>
                $(document).ready(function () {
                // Form submission event
                $('form').on('submit', function () {
                    // $('#spinner').addClass('show'); // Show the spinner when the request starts
                    $('#custom_spinner').addClass('show'); // Show the spinner when the request starts
                });

                // Translate
                $('#translateBtn').click(function() {
                    let prompt = $('#custom_prompt').val();
                    console.log(prompt);
                    $('#custom_spinner').addClass('show');
                    let csrfToken = $('meta[name="csrf-token"]').attr('content'); // Get CSRF token

                    let translateUrl = "{{ route('prompts.translate') }}"; // Get the named route url here

                    $.ajax({
                        url: translateUrl, // Use the named route url
                        type: 'POST',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        data: {
                            prompt: prompt
                        },
                        success: function(data) {
                            $('#custom_spinner').removeClass('show');
                            console.log(data);
                            if (data.error) {

                                // $('#translatedText').html('<p style="color:red;">' + data.error + '</p>');
                            } else {
                                $('#custom_prompt').val(data.translatedText);
                                // $('#translatedText').html('<p>' + data.translatedText + '</p>');
                            }
                        },
                        error: function() {
                            $('#custom_spinner').removeClass('show');
                            console.log('An unexpected error occurred.');
                            // $('#translatedText').html('<p style="color:red;">An unexpected error occurred.</p>');
                        }
                    });
                });
        
            });

            // Download AI Response
            function downloadFile(type) {
                let aiResponse = document.getElementById('ai-response').innerText;

                let form = document.createElement('form');
                form.method = 'POST';
                form.action = type === 'pdf' ? "{{ route('ai.download.pdf') }}" : "{{ route('ai.download.doc') }}";
                form.style.display = 'none';

                let csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = "{{ csrf_token() }}";
                form.appendChild(csrf);

                let responseInput = document.createElement('input');
                responseInput.type = 'hidden';
                responseInput.name = 'ai_response';
                responseInput.value = aiResponse;
                form.appendChild(responseInput);

                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);
            }
        </script>
    @endpush

    
</x-app-layout>