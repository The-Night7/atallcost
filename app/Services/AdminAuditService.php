<?php

declare(strict_types=1);

namespace App\Services;

use App\Support\SupabaseClient;

final class AdminAuditService
{
    public function __construct(private SupabaseClient $supabase)
    {
    }

    public function log(array $admin, string $action, string $targetType, ?string $targetId, array $payload = []): void
    {
        $this->supabase->insert('admin_audit_logs', [[
            'admin_profile_id' => $admin['id'] ?? null,
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'payload_json' => $payload,
        ]]);
    }
}
