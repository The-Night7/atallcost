<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\PoleRepository;
use App\Repositories\ProfileRepository;

final class ProfileService
{
    public function __construct(
        private ProfileRepository $profiles,
        private PoleRepository $poles
    ) {
    }

    public function createPendingProfile(array $payload): array
    {
        return $this->profiles->create($payload);
    }

    public function findByAuthUserId(string $authUserId): ?array
    {
        return $this->profiles->findByAuthUserId($authUserId);
    }

    public function allForAdmin(): array
    {
        $profiles = $this->profiles->all();
        foreach ($profiles as &$profile) {
            $profile['poles'] = $this->poles->forProfile($profile['id']);
        }
        return $profiles;
    }

    public function activeMembersDirectory(): array
    {
        return $this->profiles->activeMembers();
    }

    public function updateStatus(string $profileId, string $status): array
    {
        return $this->profiles->updateStatus($profileId, $status);
    }

    public function archive(string $profileId): array
    {
        return $this->profiles->archive($profileId);
    }

    public function assignPoles(string $profileId, array $poleIds): void
    {
        $this->poles->replaceProfilePoles($profileId, $poleIds);
    }
}
