<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string'
        ]);

        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            return response()->json([
                'reply' => '❌ GEMINI_API_KEY belum diisi di file .env'
            ], 500);
        }

        try {
            $response = Http::withoutVerifying()->withHeaders([
                'Content-Type' => 'application/json'
            ])->post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey,
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $request->message]
                            ]
                        ]
                    ]
                ]
            );

            $data = $response->json();

            // sesuai struktur log lo
            if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                Log::error($data);
                return response()->json([
                    'reply' => '❌ Gemini tidak memberi jawaban'
                ], 500);
            }

            return response()->json([
                'reply' => $data['candidates'][0]['content']['parts'][0]['text']
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'reply' => '❌ Gagal menghubungi server Gemini'
            ], 500);
        }
    }
}
