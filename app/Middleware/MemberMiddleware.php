<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Http\Request;
use App\Http\Response;
use App\Services\SessionService;

final class MemberMiddleware
{
    public function __construct(private SessionService $session)
    {
    }

    public function handle(Request $request, callable $next): Response
    {
        $user = $this->session->user();
        $status = $user['status'] ?? null;

        if (!in_array($status, ['member', 'staff', 'admin'], true)) {
            return Response::redirect('/attente-validation');
        }

        return $next($request);
    }
}
