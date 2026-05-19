<?php

declare(strict_types=1);

namespace App\Services;

interface AICodeProviderInterface
{
    public function fetchForUser(array $user): array;
}
