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
                    <h6>Reset Password</h6>
                   
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf
                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ old('email', $request->email) }}" required>
                            <label for="email">Email address</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                            <label for="password">Password</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password" name="password_confirmation">
                            <label for="password_confirmation">Confirm Password</label>
                        </div>
                        <button type="submit" class="btn btn-primary py-3 w-100 mb-4">Reset</button>

                    </form>
                </div>
            </div>
        </div>
    </div>



</x-guest-layout>
