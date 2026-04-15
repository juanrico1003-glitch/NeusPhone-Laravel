<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestGeminiConnection extends Command
{
    protected $signature = 'gemini:test';
    protected $description = 'Prueba la conexión con la API de Gemini';

    public function handle()
    {
        $apiKey = config('services.gemini.api_key');
        $model = config('services.gemini.model', 'gemini-1.5-flash');

        $this->info('🔍 Verificando configuración de Gemini...');
        $this->newLine();

        // Verificar si hay API key configurada
        if (empty($apiKey)) {
            $this->error('❌ No hay API key configurada');
            $this->line('   Debes agregar GEMINI_API_KEY en tu archivo .env');
            return 1;
        }

        $this->info('✅ API key encontrada: ' . substr($apiKey, 0, 8) . '...');
        $this->info('📦 Modelo configurado: ' . $model);
        $this->newLine();

        // Probar conexión con Gemini
        $this->info('🌐 Probando conexión con Gemini...');
        $this->newLine();

        try {
            $response = Http::timeout(30)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => 'Responde solo: "Conexión exitosa"'],
                            ],
                        ],
                    ],
                ]
            );

            if ($response->successful()) {
                $texto = data_get($response->json(), 'candidates.0.content.parts.0.text');
                $this->info('✅ ¡Conexión exitosa con Gemini!');
                $this->newLine();
                $this->info('Respuesta de Gemini:');
                $this->line('   ' . trim($texto));
                $this->newLine();
                $this->info('🤖 El chatbot está listo para usar');
                return 0;
            }

            // Si no fue exitoso, analizar el error
            $error = $response->json();
            $errorMessage = data_get($error, 'error.message', 'Error desconocido');

            $this->error('❌ Error en la conexión:');
            $this->line('   ' . $errorMessage);
            $this->newLine();

            // Detectar tipo de error
            if (str_contains($errorMessage, 'API key not valid')) {
                $this->error('🔑 La API key es inválida');
                $this->line('   Verifica que la clave sea correcta en el archivo .env');
            } elseif (str_contains($errorMessage, 'quota') || str_contains($errorMessage, 'billing') || str_contains($errorMessage, 'credit')) {
                $this->error('💳 Sin créditos disponibles');
                $this->line('   Tu cuenta de Google Cloud no tiene créditos o ha excedido la cuota');
                $this->line('   Visita: https://console.cloud.google.com/billing');
            } elseif (str_contains($errorMessage, 'not found')) {
                $this->error('🤖 Modelo no encontrado');
                $this->line('   El modelo ' . $model . ' no existe');
                $this->line('   Intenta con: gemini-2.0-flash o gemini-1.5-flash');
            } else {
                $this->error('⚠️ Error general');
                $this->line('   Revisa tu conexión a internet y la configuración');
            }

            return 1;

        } catch (\Illuminate\Http\Client\ConnectionException $e) {
            $this->error('❌ Error de conexión (ConnectionException)');
            $this->line('   Mensaje: ' . $e->getMessage());
            $this->newLine();
            $this->line('   Posibles causas:');
            $this->line('   - Sin conexión a internet');
            $this->line('   - Firewall o proxy bloqueando la conexión');
            $this->line('   - Problema de certificado SSL');
            $this->newLine();
            $this->info('💡 Intentando con SSL desactivado...');
            
            // Intentar sin verificación SSL
            try {
                $response = Http::timeout(30)->withOptions([
                    'verify' => false,
                ])->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}",
                    [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => 'Responde solo: "Conexión exitosa"'],
                                ],
                            ],
                        ],
                    ]
                );
                
                if ($response->successful()) {
                    $this->info('✅ ¡Conexión exitosa sin SSL!');
                    $this->line('   El problema es el certificado SSL de tu sistema.');
                    $this->line('   Actualiza los certificados o desactiva verify_ssl en config/services.php');
                } else {
                    $this->error('❌ Siguió fallando sin SSL');
                    $this->line('   Error: ' . data_get($response->json(), 'error.message', 'Desconocido'));
                }
            } catch (\Exception $e2) {
                $this->error('❌ También falló sin SSL: ' . $e2->getMessage());
            }
            
            return 1;
        } catch (\Exception $e) {
            $this->error('❌ Error inesperado');
            $this->line('   ' . $e->getMessage());
            return 1;
        }
    }
}
