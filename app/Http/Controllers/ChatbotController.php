<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
   public function send(Request $request)
{
    $message = $request->message;
    $apiKey = env('GEMINI_API_KEY');

    $response = Http::post(
        "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}",
        [
            "contents" => [
                [
                    "parts" => [
                        [
                            "text" => $message
                        ]
                    ]
                ]
            ]
        ]
    );

    $data = $response->json();

    return response()->json([
        'reply' => $data['candidates'][0]['content']['parts'][0]['text']
            ?? 'No pude generar una respuesta.'
    ]);
}
}