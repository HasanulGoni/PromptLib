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

                <div class="card mt-3">
                    @if(auth()->user()->isPremium())
                        <form action="{{ route('subscriptions.cancel') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Cancel Subscription</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>