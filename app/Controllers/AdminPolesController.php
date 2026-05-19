<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\AdminAuditService;
use App\Services\PoleService;
use App\Services\SessionService;
use App\Support\View;

final class AdminPolesController
{
    public function __construct(
        private View $view,
        private PoleService $poles,
        private SessionService $session,
        private AdminAuditService $audit
    ) {
    }

    public function index(Request $request): Response
    {
        return $this->view->make('admin/poles', [
            'poles' => $this->poles->all(),
        ]);
    }

    public function store(Request $request): Response
    {
        try {
            $pole = $this->poles->create(['name' => (string) $request->input('name')]);
            $this->audit->log($this->session->user() ?? [], 'pole.create', 'pole', $pole['id'] ?? null, $pole);
            $this->session->flash('success', 'Pole cree.');
        } catch (\Throwable $e) {
            $this->session->flash('error', $e->getMessage());
        }

        return Response::redirect('/admin/poles');
    }

    public function update(Request $request): Response
    {
        try {
            $pole = $this->poles->update((string) $request->routeParam('id'), ['name' => (string) $request->input('name')]);
            $this->audit->log($this->session->user() ?? [], 'pole.update', 'pole', $request->routeParam('id'), $pole);
            $this->session->flash('success', 'Pole modifie.');
        } catch (\Throwable $e) {
            $this->session->flash('error', $e->getMessage());
        }

        return Response::redirect('/admin/poles');
    }

    public function archive(Request $request): Response
    {
        try {
            $this->poles->archive((string) $request->routeParam('id'));
            $this->audit->log($this->session->user() ?? [], 'pole.archive', 'pole', $request->routeParam('id'));
            $this->session->flash('success', 'Pole archive.');
        } catch (\Throwable $e) {
            $this->session->flash('error', $e->getMessage());
        }

        return Response::redirect('/admin/poles');
    }
}
