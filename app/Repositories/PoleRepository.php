<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Support\SupabaseClient;

final class PoleRepository
{
    public function __construct(private SupabaseClient $supabase)
    {
    }

    public function all(): array
    {
        return $this->supabase->select('poles', [
            'select' => '*',
            'order' => 'name.asc',
        ]);
    }

    public function create(array $payload): array
    {
        $rows = $this->supabase->insert('poles', [$payload]);
        return $rows[0] ?? $payload;
    }

    public function update(string $id, array $payload): array
    {
        $rows = $this->supabase->update('poles', $payload, ['id' => 'eq.' . $id]);
        return $rows[0] ?? $payload;
    }

    public function archive(string $id): array
    {
        $rows = $this->supabase->update('poles', [
            'is_active' => false,
            'archived_at' => date(DATE_ATOM),
        ], ['id' => 'eq.' . $id]);

        return $rows[0] ?? [];
    }

    public function forProfile(string $profileId): array
    {
        $rows = $this->supabase->select('profile_poles', [
            'select' => 'pole_id,poles(id,name,slug)',
            'profile_id' => 'eq.' . $profileId,
        ]);

        return array_map(static fn (array $row) => $row['poles'] ?? [], $rows);
    }

    public function replaceProfilePoles(string $profileId, array $poleIds): void
    {
        $this->supabase->rpc('replace_profile_poles', [
            'p_profile_id' => $profileId,
            'p_pole_ids' => array_values($poleIds),
        ]);
    }
}
