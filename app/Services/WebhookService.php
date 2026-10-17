<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WebhookService
{
    public static function send(string $formType, array $data): void
    {
        $url    = config('services.webhook.url');
        $apiKey = config('services.webhook.api_key');

        if (empty($url) || empty($apiKey)) {
            return;
        }

        // Remove Laravel internal fields CRM doesn't need
        unset($data['id'], $data['created_at'], $data['updated_at'], $data['status']);

        // Convert any array fields to comma-separated strings for CRM compatibility
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = implode(', ', $value);
            }
        }

        // Add form source tag
        $data['form_type'] = $formType;

        try {
            $response = Http::withHeaders([
                'X-API-KEY'    => $apiKey,
                'Content-Type' => 'application/json',
                'Accept'       => 'application/json',
            ])->timeout(5)->post($url, $data);

            Log::info('Webhook sent', [
                'form_type' => $formType,
                'status'    => $response->status(),
                'response'  => $response->json(),
            ]);
        } catch (\Throwable $e) {
            Log::error('Webhook send failed', [
                'form_type' => $formType,
                'error'     => $e->getMessage(),
            ]);
        }
    }
}
