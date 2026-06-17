<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
   public function send(Request $request)
{

    $apiKey = env('GEMINI_API_KEY');

    $response = Http::get(
        "https://generativelanguage.googleapis.com/v1beta/models?key={$apiKey}"    
    );

    return response()->json([
        'api_key_exists' => !empty($apikey),
        'status' => $response->status(),
        'body'=>$response->body(),
        'json'=>$response->json()
    ]);
    }
}