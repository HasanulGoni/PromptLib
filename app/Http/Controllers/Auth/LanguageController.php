<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
class LanguageController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        // dd($request);

        $user = User::find(Auth::user())->first();

        $user->language = $request->language;
        $user->update();

        return back()->with('success', 'Language Updated Successfully');
    }
}
