<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Support\SupabaseClient;

final class AnnouncementRepository
{
    public function __construct(private SupabaseClient $supabase)
    {
    }

    public function allVisible(): array
    {
        return $this->supabase->select('internal_announcements', [
            'select' => '*',
            'archived_at' => 'is.null',
            'order' => 'published_at.desc',
        ]);
    }

    public function all(): array
    {
        return $this->supabase->select('internal_announcements', [
            'select' => '*',
            'order' => 'published_at.desc',
        ]);
    }

    public function create(array $payload): array
    {
        $rows = $this->supabase->insert('internal_announcements', [$payload]);
        return $rows[0] ?? $payload;
    }

    public function update(string $id, array $payload): array
    {
        $rows = $this->supabase->update('internal_announcements', $payload, ['id' => 'eq.' . $id]);
        return $rows[0] ?? $payload;
    }

    public function archive(string $id): array
    {
        $rows = $this->supabase->update('internal_announcements', [
            'archived_at' => date(DATE_ATOM),
        ], ['id' => 'eq.' . $id]);

        return $rows[0] ?? [];
    }
}
