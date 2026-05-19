<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Http\Request;
use App\Http\Response;
use App\Services\SessionService;

final class AuthMiddleware
{
    public function __construct(private SessionService $session)
    {
    }

    public function handle(Request $request, callable $next): Response
    {
        if ($this->session->user() === null) {
            $this->session->flash('error', 'Veuillez vous connecter.');
            return Response::redirect('/connexion');
        }

        return $next($request);
    }
}
