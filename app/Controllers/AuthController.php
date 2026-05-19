<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\SessionService;
use App\Services\SupabaseAuthService;
use App\Support\View;
use RuntimeException;

final class AuthController
{
    public function __construct(
        private View $view,
        private SupabaseAuthService $auth,
        private SessionService $session
    ) {
    }

    public function showLogin(Request $request): Response
    {
        return $this->view->make('auth/login');
    }

    public function showRegister(Request $request): Response
    {
        return $this->view->make('auth/register');
    }

    public function pending(Request $request): Response
    {
        return $this->view->make('auth/pending');
    }

    public function register(Request $request): Response
    {
        try {
            $data = $request->all();
            if (($data['password'] ?? '') !== ($data['password_confirmation'] ?? '')) {
                throw new RuntimeException('Les mots de passe ne correspondent pas.');
            }

            $profile = $this->auth->register($data);
            $this->session->flash('success', 'Compte cree. Validation admin necessaire.');
            return Response::redirect(($profile['status'] ?? '') === 'pending' ? '/attente-validation' : '/annonces');
        } catch (\Throwable $e) {
            $this->session->flash('error', $e->getMessage());
            return Response::redirect('/inscription');
        }
    }

    public function login(Request $request): Response
    {
        try {
            $profile = $this->auth->login((string) $request->input('email'), (string) $request->input('password'));
            return Response::redirect(in_array($profile['status'] ?? '', ['member', 'staff', 'admin'], true) ? '/annonces' : '/attente-validation');
        } catch (\Throwable $e) {
            $this->session->flash('error', $e->getMessage());
            return Response::redirect('/connexion');
        }
    }

    public function logout(Request $request): Response
    {
        $this->session->logout();
        return Response::redirect('/');
    }

    public function googleStart(Request $request): Response
    {
        return Response::redirect($this->auth->beginGoogleLogin());
    }

    public function googleCallback(Request $request): Response
    {
        try {
            $profile = $this->auth->completeGoogleLogin((string) $request->query('code'));
            return Response::redirect(in_array($profile['status'] ?? '', ['member', 'staff', 'admin'], true) ? '/annonces' : '/attente-validation');
        } catch (\Throwable $e) {
            $this->session->flash('error', $e->getMessage());
            return Response::redirect('/connexion');
        }
    }
}
