<?php

declare(strict_types=1);

namespace App\Services;

final class StubAICodeProvider implements AICodeProviderInterface
{
    public function __construct(private array $config)
    {
    }

    public function fetchForUser(array $user): array
    {
        $seed = substr(hash('sha256', ($user['email'] ?? 'aac') . date('Y-m-d-H')), 0, 12);

        return [
            'ai_code' => strtoupper(substr($seed, 0, 6)),
            'validation_code' => strtoupper(substr(strrev($seed), 0, 6)),
            'source' => (string) ($this->config['provider_name'] ?? 'stub'),
            'requested_at' => date(DATE_ATOM),
            'raw_reference' => 'stub:' . ($user['id'] ?? 'guest'),
            'status' => 'success',
        ];
    }
}
