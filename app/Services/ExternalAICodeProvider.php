<?php

declare(strict_types=1);

namespace App\Services;

use RuntimeException;

final class ExternalAICodeProvider implements AICodeProviderInterface
{
    public function __construct(private array $config)
    {
    }

    public function fetchForUser(array $user): array
    {
        if (($this->config['api_url'] ?? '') === '') {
            throw new RuntimeException('AI_CODE_API_URL manquante');
        }

        $ch = curl_init($this->config['api_url']);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_TIMEOUT => (int) ($this->config['timeout'] ?? 10),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . ($this->config['api_key'] ?? ''),
            ],
            CURLOPT_POSTFIELDS => json_encode([
                'email' => $user['email'] ?? null,
                'profile_id' => $user['id'] ?? null,
            ], JSON_THROW_ON_ERROR),
        ]);

        $raw = curl_exec($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($raw === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new RuntimeException($error);
        }
        curl_close($ch);

        $decoded = json_decode($raw, true);
        if ($httpCode >= 400 || !is_array($decoded)) {
            throw new RuntimeException('Provider externe invalide');
        }

        return [
            'ai_code' => (string) ($decoded['ai_code'] ?? ''),
            'validation_code' => (string) ($decoded['validation_code'] ?? ''),
            'source' => (string) ($decoded['source'] ?? $this->config['provider_name']),
            'requested_at' => date(DATE_ATOM),
            'raw_reference' => $decoded['raw_reference'] ?? substr($raw, 0, 255),
            'status' => (string) ($decoded['status'] ?? 'success'),
        ];
    }
}
