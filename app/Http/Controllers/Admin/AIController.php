<?php

namespace App\Http\Controllers\Admin;

use OpenAI;
use App\Models\Prompt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AIController extends Controller
{
    public function sendToAI(Request $request)
    {
        if (!Auth::user()->isPremium()) {
            return back()->with(['warning' => 'Upgrade to premium to use AI Integration.']);
        }
        // dd($request);
        $request->validate([
            'custom_prompt' => 'string|max:1000',
        ]);

        // Use provided prompt text or custom user input
        $promptText = $request->custom_prompt;

        $client = OpenAI::client(env('OPENAI_API_KEY'));

        try {
            $response = $client->chat()->create([
                'model' => 'gpt-4',
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                    ['role' => 'user', 'content' => $promptText]
                ],
                'max_tokens' => 500,
                'temperature' => 0.7,
            ]);
    
            // dd($response['choices'][0]['message']['content']); // Debugging output
    
            return back()->with('ai_response', $response['choices'][0]['message']['content']);
        } catch (\Exception $e) {
            // dd($e);
            return back()->withErrors(['error' => 'Failed to generate AI response.']);
        }
    }
}
