<x-app-layout>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="bg-secondary rounded h-100 p-4">
                <h2>Profile</h2>
            </div>
        </div>
        
    </div>
    <div class="container-fluid pt-4 px-4">
        <div class="row g-4">
            <div class="bg-secondary rounded h-100 p-4">
                <h4>Profile Information</h4>
                <h6>
                    Update your account's profile information and email address.
                </h6>

                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                    @csrf
                </form>
                <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('patch')
            
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>

                    </div>
            
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>

            
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div>
                                <p class="text-sm mt-2 text-gray-800">
                                    {{ __('Your email address is unverified.') }}
            
                                    <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        {{ __('Click here to re-send the verification email.') }}
                                    </button>
                                </p>
            
                                @if (session('status') === 'verification-link-sent')
                                    <p class="mt-2 font-medium text-sm text-green-600">
                                        {{ __('A new verification link has been sent to your email address.') }}
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
            
                    <div class="flex items-center gap-4">
                        <x-primary-button class="btn btn-primary">{{ __('Save') }}</x-primary-button>
            
                      
                    </div>
                </form>
            </div>
        </div>
        
    </div>

    <div class="container-fluid pt-4 px-4">
        <div  class="row g-4">
            <div class="bg-secondary rounded h-100 p-4">
                <h4>Update Password </h4>
                <h6>
                    Ensure your account is using a long, random password to stay secure. 
                </h6>

                <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="update_password_current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="update_password_current_password" name="current_password" autocomplete="current-password" required>

                    </div>
                    <div class="mb-3">
                        <label for="update_password_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="update_password_password" name="password" required autocomplete="new-password">

                    </div>
                    <div class="mb-3">
                        <label for="update_password_password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="update_password_password_confirmation" name="password_confirmation" required>

                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-4 px-4">
        <div  class="row g-4">
            <div class="bg-secondary rounded h-100 p-4">
                <h4>Language</h4>
                <h6>
                    You can translate any prompt into any language
                </h6>

                <form method="post" action="{{ route('language.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="status" class="form-label">Language</label>
                        <select class="form-select mb-3" name="language">
                            <option>Select a language</option>
                            @php
                                $langs = App\Models\Language::all();
                                // dd(Auth::user()->language);
                            @endphp
                            @foreach ($langs as $lang)
                            
                            <option value="{{$lang->language_code}}" {{ Auth::user()->language == $lang->language_code ? "selected" : "" }}>{{ $lang->language_name }}</option>
                            @endforeach
                            
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
 
</x-app-layout>
