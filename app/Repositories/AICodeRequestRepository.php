<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Support\SupabaseClient;

final class AICodeRequestRepository
{
    public function __construct(private SupabaseClient $supabase)
    {
    }

    public function create(array $payload): array
    {
        $rows = $this->supabase->insert('ai_code_requests', [$payload]);
        return $rows[0] ?? $payload;
    }

    public function forUser(string $profileId): array
    {
        return $this->supabase->select('ai_code_requests', [
            'select' => '*',
            'profile_id' => 'eq.' . $profileId,
            'order' => 'requested_at.desc',
            'limit' => '10',
        ]);
    }

    public function all(): array
    {
        return $this->supabase->select('v_ai_code_requests_admin', [
            'select' => '*',
            'order' => 'requested_at.desc',
        ]);
    }
}
