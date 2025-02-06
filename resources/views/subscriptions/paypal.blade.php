<x-app-layout>
    @push('styles')
        <style>
            .bg-darkgray{
                background-color: #a9a9a9;
            }
            .bg-aliceblue{
                background-color: #f0f8ff;
            }
            .text-premium{
                color: #ff8707;;
            }
        </style>
    @endpush
    <div class="container-fluid pt-4 px-4">
      
        <div class="mt-4">
            <div class="container">
                <h2>PayPal Subscription Plans</h2>
            
                <div class="card bg-darkgray mt-5">
                    <div class="card-body">
                        <h4 class="text-black-50">Free Plan</h4>
                        <h3 class="text-body">Unlimited searches</h3>
                        <button class="btn btn-secondary">Active</button>
                    </div>
                </div>
            
                <div class="card mt-3 bg-aliceblue">
                    <div class="card-body">
                        <h4 class="text-premium">Premium Plan - $9.99/month</h3>
                        <h3 class="text-dark">Unlimited searches, AI API access & premium features</p>
                        <form action="{{ route('subscriptions.paypal.create') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Subscribe with PayPal</button>
                        </form>
                    </div>
                </div>
                <div class="card mt-3 bg-aliceblue">
                    <div class="card-body">
                        <h4 class="text-info">Current Subscription Plan</h3>
                        <p class="text-dark mb-0 text-capitalize fs-3">{{ Auth::user()->subscription->plan }}</p>
                            <p class="fa">Expair Date: {{ Auth::user()->subscription->expires_at }}</p>
                    </div>
                </div>
                {{-- <div class="card mt-3 mt-3">
                    @if(auth()->user()->isPremium())
                        <form action="{{ route('subscriptions.paypal.cancel') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Cancel Subscription</button>
                        </form>
                    @endif
                </div> --}}
            </div>
        </div>
    </div>
</x-app-layout>