<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InstructorJoin; // ⬅ penting Bang!

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

        // ============================
        // 1. SIMPAN KE DATABASE
        // ============================
        InstructorJoin::create([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        // ============================
        // 2. KIRIM KE TELEGRAM
        // ============================
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

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return back()->with('error', "Gagal mengirim pesan ke Telegram: {$error_msg}");
        }

        $result = json_decode($response, true);

        if (!$result['ok']) {
            return back()->with('error', 'Gagal mengirim pesan ke Telegram: ' . $result['description']);
        }

        curl_close($ch);

        return back()->with('success', 'Terkirim, terima kasih sudah mendaftar sebagai instruktur! Silahkan tunggu informasi selanjutnya melalui email.');
    }
}
