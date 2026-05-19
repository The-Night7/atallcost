<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Repositories\AICodeRequestRepository;
use App\Services\AICodeProviderInterface;
use App\Services\SessionService;

final class AICodeController
{
    public function __construct(
        private AICodeProviderInterface $provider,
        private AICodeRequestRepository $requests,
        private SessionService $session
    ) {
    }

    public function fetch(Request $request): Response
    {
        $user = $this->session->user();

        try {
            $result = $this->provider->fetchForUser($user ?? []);
            $this->requests->create([
                'profile_id' => $user['id'] ?? null,
                'provider' => $result['source'],
                'request_status' => $result['status'],
                'ai_code_masked' => $this->mask($result['ai_code']),
                'validation_code_masked' => $this->mask($result['validation_code']),
                'response_excerpt' => substr((string) $result['raw_reference'], 0, 255),
                'http_status' => 200,
            ]);

            return Response::json($result);
        } catch (\Throwable $e) {
            $this->requests->create([
                'profile_id' => $user['id'] ?? null,
                'provider' => config('ai_codes.provider_name', 'default'),
                'request_status' => 'error',
                'ai_code_masked' => null,
                'validation_code_masked' => null,
                'response_excerpt' => substr($e->getMessage(), 0, 255),
                'http_status' => $e->getCode() ?: 500,
            ]);

            return Response::json(['error' => $e->getMessage()], 500);
        }
    }

    private function mask(?string $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        $length = strlen($value);
        if ($length <= 2) {
            return str_repeat('*', $length);
        }

        return substr($value, 0, 1) . str_repeat('*', $length - 2) . substr($value, -1);
    }
}
