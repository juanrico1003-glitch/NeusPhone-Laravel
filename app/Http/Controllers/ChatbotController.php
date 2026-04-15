<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class ChatbotController extends Controller
{
    public function recomendar(Request $request): JsonResponse
    {
        $request->validate([
            'mensaje' => ['required', 'string', 'max:500'],
        ]);

        $apiKey = config('services.gemini.api_key');
        $model = config('services.gemini.model', 'gemini-1.5-flash');

        if (empty($apiKey)) {
            return response()->json([
                'respuesta' => 'Actualmente no estoy disponible para responder consultas. Por favor, vuelve más tarde.',
            ], 200);
        }

        $mensajeUsuario = $request->string('mensaje')->toString();

        $productos = Producto::with(['marca', 'categoria', 'color', 'almacenamiento'])
            ->where('estado', 1)
            ->where('stock', '>', 0)
            ->orderBy('precio')
            ->limit(40)
            ->get()
            ->map(function (Producto $producto) {
                return [
                    'nombre' => $producto->nombre,
                    'tipo' => $producto->tipo,
                    'precio' => (float) $producto->precio,
                    'stock' => (int) ($producto->stock ?? 0),
                    'marca' => optional($producto->marca)->nombre,
                    'categoria' => optional($producto->categoria)->nombre,
                    'color' => optional($producto->color)->nombre,
                    'almacenamiento' => optional($producto->almacenamiento)->capacidad,
                    'descripcion' => $producto->descripcion,
                ];
            });

        $catalogo = $productos
            ->map(function (array $item) {
                return sprintf(
                    '- %s | %s | %s | %s | $%s | stock: %d',
                    $item['nombre'] ?? 'Sin nombre',
                    $item['marca'] ?? 'Sin marca',
                    $item['categoria'] ?? 'Sin categoria',
                    $item['tipo'] ?? 'sin tipo',
                    number_format((float) ($item['precio'] ?? 0), 0, ',', '.'),
                    (int) ($item['stock'] ?? 0)
                );
            })
            ->implode("\n");

        $prompt = "Eres el asistente virtual de NeusPhone, una tienda de dispositivos electronicos nuevos y usados.\n"
            ."Tu objetivo es recomendar productos reales del catalogo.\n"
            ."Reglas:\n"
            ."- Responde SIEMPRE en espanol.\n"
            ."- Solo recomienda productos presentes en el catalogo.\n"
            ."- Si no hay coincidencias, dilo y sugiere alternativas por presupuesto, tipo o marca.\n"
            ."- Da respuestas cortas y claras (maximo 6 lineas).\n"
            ."- Si el cliente da una idea general (ej: para stream, estudio, trabajo), recomienda de forma autonoma lo mas adecuado.\n\n"
            ."Catalogo disponible:\n".$catalogo."\n\n"
            ."Pregunta del cliente: ".$mensajeUsuario;

        try {
            $http = Http::timeout(20)->withOptions([
                'verify' => filter_var(config('services.gemini.verify_ssl', true), FILTER_VALIDATE_BOOL),
            ]);

            $payload = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt],
                        ],
                    ],
                ],
            ];

            $response = $http->post(
                "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
                $payload
            );

            // Fallback por si el modelo configurado no existe en la version actual.
            if (
                ! $response->successful()
                && str_contains((string) data_get($response->json(), 'error.message', ''), 'is not found')
                && $model !== 'gemini-2.0-flash'
            ) {
                $response = $http->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}",
                    $payload
                );
            }
        } catch (ConnectionException $exception) {
            return response()->json([
                'respuesta' => 'Actualmente no estoy disponible para responder consultas. Por favor, vuelve más tarde.',
            ], 200);
        }

        // Si la respuesta no es exitosa, puede ser por falta de créditos u otros errores
        if (! $response->successful()) {
            $errorMessage = data_get($response->json(), 'error.message', '');
            
            // Si hay error relacionado con cuota, créditos o API key inválida
            if (
                str_contains($errorMessage, 'quota') ||
                str_contains($errorMessage, 'billing') ||
                str_contains($errorMessage, 'credit') ||
                str_contains($errorMessage, 'exhausted') ||
                str_contains($errorMessage, 'invalid') ||
                str_contains($errorMessage, 'permission') ||
                $response->status() === 429
            ) {
                return response()->json([
                    'respuesta' => 'Actualmente no estoy disponible para responder consultas. Por favor, vuelve más tarde.',
                ], 200);
            }
            
            return response()->json([
                'respuesta' => 'Actualmente no estoy disponible para responder consultas. Por favor, vuelve más tarde.',
            ], 200);
        }

        $texto = data_get($response->json(), 'candidates.0.content.parts.0.text');

        if (! is_string($texto) || trim($texto) === '') {
            $texto = 'No encontre una recomendacion clara con esa consulta. Puedes decirme presupuesto, marca o tipo (nuevo/usado).';
        }

        return response()->json([
            'respuesta' => trim($texto),
        ]);
    }
}
