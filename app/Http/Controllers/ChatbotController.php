<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function send(Request $request)
    {
        try {
            $response = Http::timeout(120)
                ->post('http://127.0.0.1:5678/webhook/neusphone/chat', [
                    'message' => $request->message,
                    'user' => auth()->check() ? auth()->user()->name : 'Cliente'
                ]);

            $data = $response->json();

            return response()->json([
                'reply' => $data['reply'] ?? 'No hubo respuesta de la IA.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'reply' => 'Tenemos problemas locales. Intenta nuevamente.'
            ], 500);
        }
    }
}