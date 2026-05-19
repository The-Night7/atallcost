<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\AdminAuditService;
use App\Services\PoleService;
use App\Services\ProfileService;
use App\Services\SessionService;
use App\Services\SupabaseAuthService;
use App\Support\View;

final class AdminUsersController
{
    public function __construct(
        private View $view,
        private ProfileService $profiles,
        private PoleService $poles,
        private SessionService $session,
        private AdminAuditService $audit,
        private SupabaseAuthService $auth
    ) {
    }

    public function index(Request $request): Response
    {
        return $this->view->make('admin/users', [
            'profiles' => $this->profiles->allForAdmin(),
            'poles' => $this->poles->all(),
        ]);
    }

    public function store(Request $request): Response
    {
        try {
            $profile = $this->auth->register($request->all(), false);
            $this->audit->log($this->session->user() ?? [], 'user.create', 'profile', $profile['id'] ?? null, ['email' => $profile['email'] ?? null]);
            $this->session->flash('success', 'Utilisateur cree.');
        } catch (\Throwable $e) {
            $this->session->flash('error', $e->getMessage());
        }

        return Response::redirect('/admin/utilisateurs');
    }

    public function updateStatus(Request $request): Response
    {
        try {
            $profile = $this->profiles->updateStatus((string) $request->routeParam('id'), (string) $request->input('status'));
            $this->audit->log($this->session->user() ?? [], 'user.status', 'profile', $request->routeParam('id'), ['status' => $profile['status'] ?? null]);
            $this->session->flash('success', 'Statut mis a jour.');
        } catch (\Throwable $e) {
            $this->session->flash('error', $e->getMessage());
        }

        return Response::redirect('/admin/utilisateurs');
    }

    public function updatePoles(Request $request): Response
    {
        try {
            $poleIds = array_filter((array) $request->input('pole_ids', []));
            $this->profiles->assignPoles((string) $request->routeParam('id'), $poleIds);
            $this->audit->log($this->session->user() ?? [], 'user.poles', 'profile', $request->routeParam('id'), ['pole_ids' => $poleIds]);
            $this->session->flash('success', 'Affectations mises a jour.');
        } catch (\Throwable $e) {
            $this->session->flash('error', $e->getMessage());
        }

        return Response::redirect('/admin/utilisateurs');
    }

    public function archive(Request $request): Response
    {
        try {
            $this->profiles->archive((string) $request->routeParam('id'));
            $this->audit->log($this->session->user() ?? [], 'user.archive', 'profile', $request->routeParam('id'));
            $this->session->flash('success', 'Compte archive.');
        } catch (\Throwable $e) {
            $this->session->flash('error', $e->getMessage());
        }

        return Response::redirect('/admin/utilisateurs');
    }
}
