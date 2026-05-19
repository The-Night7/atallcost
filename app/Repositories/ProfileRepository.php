<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Support\SupabaseClient;

final class ProfileRepository
{
    public function __construct(private SupabaseClient $supabase)
    {
    }

    public function create(array $payload): array
    {
        $rows = $this->supabase->insert('profiles', [$payload]);
        return $rows[0] ?? $payload;
    }

    public function findByAuthUserId(string $authUserId): ?array
    {
        $rows = $this->supabase->select('profiles', [
            'select' => '*',
            'auth_user_id' => 'eq.' . $authUserId,
            'limit' => '1',
        ]);

        return $rows[0] ?? null;
    }

    public function all(): array
    {
        return $this->supabase->select('profiles', [
            'select' => '*',
            'order' => 'created_at.desc',
        ]);
    }

    public function activeMembers(): array
    {
        return $this->supabase->select('profiles', [
            'select' => '*',
            'status' => 'in.(member,staff,admin)',
            'order' => 'last_name.asc',
        ]);
    }

    public function updateStatus(string $profileId, string $status): array
    {
        $payload = ['status' => $status];
        if ($status !== 'pending') {
            $payload['validated_at'] = date(DATE_ATOM);
        }

        $rows = $this->supabase->update('profiles', $payload, ['id' => 'eq.' . $profileId]);
        return $rows[0] ?? $payload;
    }

    public function archive(string $profileId): array
    {
        $rows = $this->supabase->update('profiles', [
            'status' => 'archived',
            'archived_at' => date(DATE_ATOM),
        ], ['id' => 'eq.' . $profileId]);

        return $rows[0] ?? [];
    }
}
