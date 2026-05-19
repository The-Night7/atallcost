<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Http\Request;
use App\Http\Response;
use App\Services\SessionService;

final class CsrfMiddleware
{
    public function __construct(private SessionService $session)
    {
    }

    public function handle(Request $request, callable $next): Response
    {
        $token = (string) ($request->input('_csrf') ?? $request->server('HTTP_X_CSRF_TOKEN', ''));
        if (!$this->session->verifyCsrfToken($token)) {
            if ($request->expectsJson()) {
                return Response::json(['error' => 'Jeton CSRF invalide'], 419);
            }

            $this->session->flash('error', 'Jeton CSRF invalide.');
            return Response::redirect($_SERVER['HTTP_REFERER'] ?? '/');
        }

        return $next($request);
    }
}
