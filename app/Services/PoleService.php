<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\PoleRepository;

final class PoleService
{
    public function __construct(private PoleRepository $poles)
    {
    }

    public function all(): array
    {
        return $this->poles->all();
    }

    public function create(array $payload): array
    {
        $payload['slug'] = $this->slugify($payload['name']);
        $payload['is_active'] = true;
        return $this->poles->create($payload);
    }

    public function update(string $id, array $payload): array
    {
        $payload['slug'] = $this->slugify($payload['name']);
        return $this->poles->update($id, $payload);
    }

    public function archive(string $id): array
    {
        return $this->poles->archive($id);
    }

    private function slugify(string $value): string
    {
        $value = strtolower(trim($value));
        $value = preg_replace('/[^a-z0-9]+/', '-', iconv('UTF-8', 'ASCII//TRANSLIT', $value) ?: $value);
        return trim((string) $value, '-') ?: 'pole';
    }
}
