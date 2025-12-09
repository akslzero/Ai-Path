<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ChatHistory;
use Illuminate\Support\Facades\Auth;

class AiController extends Controller
{

    public function profilePage() // atau method apapun yang nge-render view
    {
        $histories = ChatHistory::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        return view('your.view.name', compact('histories'));
    }

    public function history()
    {
        $histories = \App\Models\ChatHistory::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($histories);
    }


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

        // simpan pesan user dulu
        $history = ChatHistory::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'reply'   => null
        ]);

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

            if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                Log::error($data);
                return response()->json([
                    'reply' => '❌ Gemini tidak memberi jawaban'
                ], 500);
            }

            $reply = $data['candidates'][0]['content']['parts'][0]['text'];

            // update balasan AI ke database
            $history->update([
                'reply' => $reply
            ]);

            return response()->json([
                'reply' => $reply
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                'reply' => '❌ Gagal menghubungi server Gemini'
            ], 500);
        }
    }
}
