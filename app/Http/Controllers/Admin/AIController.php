<?php

namespace App\Http\Controllers\Admin;

use OpenAI;
use App\Models\Prompt;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use Barryvdh\DomPDF\Facade\Pdf;
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


    // Download AI Response as PDF
    public function downloadPDF(Request $request)
    {
        // Get AI response from request instead of session
        $aiResponse = $request->ai_response;
        if (!$aiResponse) {
            return back()->withErrors(['error' => 'No AI response found to download.']);
        }
    
        $pdf = Pdf::loadView('ai.pdf', compact('aiResponse'));
        return $pdf->download('AI_Response.pdf');
    }
    
    public function downloadDOC(Request $request)
    {
        // Get AI response from request instead of session
        $aiResponse = $request->ai_response;
        if (!$aiResponse) {
            return back()->withErrors(['error' => 'No AI response found to download.']);
        }
    
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();
    
        // Add heading
        $headingStyle = ['bold' => true, 'italic' => true, 'size' => 14, 'color' => '808080'];
        $section->addText("This Response Is Powered By PromptLib.", $headingStyle, ['alignment' => 'center']);
        $section->addTextBreak(1); // Add spacing
    
        // Convert AI response into an array of lines and ensure correct line breaks
        $lines = explode("\n", trim($aiResponse));
        $firstLine = true; // Track the first paragraph
    
        foreach ($lines as $line) {
            $line = trim($line); // Remove unnecessary spaces
            if (!empty($line)) {
                if (!$firstLine) {
                    $section->addTextBreak(1); // Add a line break *before* each paragraph (except the first)
                }
                $section->addText($line);
                $firstLine = false;
            }
        }
    
        // Save and download the DOC file
        $tempFile = tempnam(sys_get_temp_dir(), 'AI_Response') . '.docx';
        $writer = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFile);
    
        return response()->download($tempFile, 'AI_Response.docx')->deleteFileAfterSend(true);
    }
    
    
    
}
