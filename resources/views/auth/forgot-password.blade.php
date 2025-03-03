<x-guest-layout>


        <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <a href="index.html" class="">
                            <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>PromptLib</h3>
                        </a>
                    </div>
                       <div class="mb-4 text-sm text-gray-600">
                            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                        </div>

                        <!-- Session Status -->
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" :value="old('email')">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                <label for="email">Email address</label>
                            </div>


                            <div class="flex items-center justify-end mt-4">
                                <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Email Password Reset Link</button>

                            </div>
                        </form>

                </div>
            </div>
        </div>
    </div>


</x-guest-layout>
