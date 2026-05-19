<?php

declare(strict_types=1);

return [
    'layout' => 'layouts/base',
    'globals' => static function (\App\Support\Container $container): array {
        $session = $container->get(\App\Services\SessionService::class);
        return [
            'appName' => config('app.name', 'At All Cost'),
            'currentUser' => $session->user(),
            'flash' => $session->consumeFlash(),
            'csrfToken' => $session->csrfToken(),
        ];
    },
];
