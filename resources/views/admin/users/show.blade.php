<x-app-layout>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h6 class="mb-4">User Details</h6>
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" readonly value="{{ $user->name }}">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email"
                                aria-describedby="emailHelp" name="email" readonly value="{{ $user->email }}">
                            
                        </div>
                        
                    </form>
                </div>
            </div>

        </div>

    </div>

    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h4>Current Membership</h4>
                    @if ($user->isPremium())
                        <h6>Premium</h6>
                    @else
                        <h6>Free</h6>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Enhance Subscription Management Start --}}

    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="col-sm-12">
                <div class="bg-secondary rounded h-100 p-4">
                    <h4>Update Membership</h4>
                    <form action="{{ route('admin.subscriptions.update', $user->id) }}" method="POST">
                        @csrf
                        <select name="plan" class="form-control">
                            <option value="free" {{ !$user->isPremium() ? 'selected' : '' }}>Free</option>
                            <option value="premium" {{ $user->isPremium() ? 'selected' : '' }}>Premium</option>
                        </select>
                        {{-- <input type="date" name="expires_at" class="form-control" value="{{ $user->subscription->expires_at }}"> --}}
                        <button type="submit" class="btn btn-primary mt-2">Update</button>
                    </form>
        
                    <form action="{{ route('admin.subscriptions.cancel', $user->id) }}" method="POST" class="mt-2">
                        @csrf
                        <button type="submit" class="btn btn-danger">Cancel Subscription</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhance Subscription Management End --}}
</x-app-layout>
