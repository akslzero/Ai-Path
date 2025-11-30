<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InstructorRegisterController extends Controller
{
    public function index()
    {
        return view('join');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'full_name' => 'required',
            'email' => 'required|email',
            'message' => 'nullable'
        ]);

        $text = "
📥 New Instructor Registration
-----------------------------------
👤 Username: {$request->username}
📝 Full Name: {$request->full_name}
📧 Email: {$request->email}
💬 Message: {$request->message}
        ";

        $token = env('TELEGRAM_BOT_TOKEN');
        $chat_id = env('TELEGRAM_CHAT_ID');

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        // Kirim via curl tanpa verify SSL
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POSTFIELDS => [
                'chat_id' => $chat_id,
                'text' => $text,
                'parse_mode' => 'Markdown'
            ],
        ]);

        // Eksekusi dan ambil respons
        $response = curl_exec($ch);

        // Cek jika ada error pada curl
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return back()->with('error', "Gagal mengirim pesan ke Telegram: {$error_msg}");
        }

        // Cek apakah Telegram API memberikan respons sukses
        $result = json_decode($response, true);

        // Jika Telegram API gagal mengirim pesan
        if (!$result['ok']) {
            return back()->with('error', 'Gagal mengirim pesan ke Telegram: ' . $result['description']);
        }

        // Tutup curl
        curl_close($ch);

        return back()->with('success', 'Terkirim bro! Siap-siap dihubungi tim ✨');
    }
}
