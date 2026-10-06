<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CrmService
{
    private const UTM_KEYS = [
        'utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content',
    ];

    public function submitLead(array $validated): array
    {
        $payload = $this->buildPayload($validated);

        try {
            $response = Http::timeout(config('services.crm.timeout', 10))
                ->post(config('services.crm.endpoint'), $payload);

            if ($response->successful()) {
                Log::info('CRM lead submitted successfully', ['email' => $validated['email']]);
                Session::forget(self::UTM_KEYS);
                return ['success' => true];
            }

            Log::error('CRM API returned error', [
                'status'  => $response->status(),
                'body'    => $response->body(),
                'payload' => $payload,
            ]);

            return ['success' => false, 'message' => 'Something went wrong. Please try again later.'];

        } catch (ConnectionException $e) {
            Log::error('CRM API connection failure', [
                'error'   => $e->getMessage(),
                'payload' => $payload,
            ]);

            return ['success' => false, 'message' => 'Could not reach our server. Please try again later.'];
        }
    }

    private function buildPayload(array $validated): array
    {
        $utmData = [];
        foreach (self::UTM_KEYS as $key) {
            $utmData[$key] = Session::get($key);
        }

        return array_merge([
            'name'    => $validated['name'],
            'phone'   => $validated['phone'],
            'email'   => $validated['email'],
            'message' => $validated['message'] ?: null,
        ], $utmData);
    }
}
