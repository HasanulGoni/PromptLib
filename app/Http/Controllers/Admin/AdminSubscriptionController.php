<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminSubscriptionController extends Controller
{
    // Show all user subscriptions
    public function index()
    {
        $subscriptions = Subscription::with('user')->paginate(10);
        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    // Update a user's subscription plan
    public function update(Request $request, User $user)
    {
        $request->validate([
            'plan' => 'required|in:free,premium',
            'expires_at' => 'nullable|date|after:today',
        ]);
    
        $subscriptionData = [
            'user_id' => $user->id,
            'plan' => $request->plan,
        ];
    
        if ($request->plan === 'free') {
            $subscriptionData['expires_at'] = now()->subDays(1);
        } else {
            if ($user->isPremium() && $user->subscription) {
                $subscriptionData['expires_at'] = $user->subscription->expires_at->addMonth();
            } else {
                $subscriptionData['expires_at'] = now()->addMonth();
            }
        }
    
        $user->subscription()->updateOrCreate(['user_id' => $user->id], $subscriptionData);
    
        return back()->with('success', 'User subscription updated successfully.');
    }

    // Cancel a user's subscription
    public function cancel(User $user)
    {
        $user->subscription()->delete();
        return back()->with('success', 'User subscription canceled.');
    }
}
