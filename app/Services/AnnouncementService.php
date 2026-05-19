<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\AnnouncementRepository;

final class AnnouncementService
{
    public function __construct(private AnnouncementRepository $announcements)
    {
    }

    public function publicLandingHighlights(): array
    {
        return [
            ['title' => 'Formation', 'description' => 'Ateliers IA, deep learning et experimentation pratique.'],
            ['title' => 'Innovation', 'description' => 'Projets concrets, hackathons et partenariats technologiques.'],
        ];
    }

    public function visibleToMembers(): array
    {
        return $this->announcements->allVisible();
    }

    public function allForAdmin(): array
    {
        return $this->announcements->all();
    }

    public function create(array $payload): array
    {
        return $this->announcements->create($payload);
    }

    public function update(string $id, array $payload): array
    {
        return $this->announcements->update($id, $payload);
    }

    public function archive(string $id): array
    {
        return $this->announcements->archive($id);
    }
}
