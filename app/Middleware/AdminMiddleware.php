<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Http\Request;
use App\Http\Response;
use App\Services\SessionService;

final class AdminMiddleware
{
    public function __construct(private SessionService $session)
    {
    }

    public function handle(Request $request, callable $next): Response
    {
        if (($this->session->user()['status'] ?? null) !== 'admin') {
            $this->session->flash('error', 'Acces reserve aux administrateurs.');
            return Response::redirect('/');
        }

        return $next($request);
    }
}
