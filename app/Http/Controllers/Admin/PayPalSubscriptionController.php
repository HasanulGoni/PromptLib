<?php

namespace App\Http\Controllers\Admin;

use App\Models\Subscription;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Auth;

class PayPalSubscriptionController extends Controller
{
    public function showPlans()
    {
        return view('subscriptions.paypal');
    }

    public function createPayment()
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "USD",
                    "value" => "9.99"
                ],
                "description" => "Premium Subscription Plan"
            ]],
            "application_context" => [
                "return_url" => route('subscriptions.paypal.success'),
                "cancel_url" => route('subscriptions.paypal.cancel'),
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return back()->withErrors(['error' => 'Something went wrong with PayPal.']);
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] == "COMPLETED") {
            Subscription::updateOrCreate(
                ['user_id' => Auth::id()],
                ['plan' => 'premium', 'expires_at' => now()->addMonth()]
            );

            return redirect()->route('dashboard')->with('success', 'Subscription activated successfully!');
        }

        return redirect()->route('subscriptions.paypal.plans')->withErrors('Payment failed.');
    }

    public function cancel()
    {
        return redirect()->route('subscriptions.paypal.plans')->withErrors('Payment was canceled.');
    }
}
