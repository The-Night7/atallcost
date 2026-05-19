<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\AdminAuditService;
use App\Services\AnnouncementService;
use App\Services\SessionService;
use App\Support\View;

final class AdminAnnouncementsController
{
    public function __construct(
        private View $view,
        private AnnouncementService $announcements,
        private SessionService $session,
        private AdminAuditService $audit
    ) {
    }

    public function index(Request $request): Response
    {
        return $this->view->make('admin/announcements', [
            'announcements' => $this->announcements->allForAdmin(),
        ]);
    }

    public function store(Request $request): Response
    {
        try {
            $announcement = $this->announcements->create([
                'title' => (string) $request->input('title'),
                'body_html' => (string) $request->input('body_html'),
                'visibility' => (string) $request->input('visibility', 'members'),
                'published_at' => date(DATE_ATOM),
                'created_by' => $this->session->user()['id'] ?? null,
            ]);
            $this->audit->log($this->session->user() ?? [], 'announcement.create', 'announcement', $announcement['id'] ?? null);
            $this->session->flash('success', 'Annonce creee.');
        } catch (\Throwable $e) {
            $this->session->flash('error', $e->getMessage());
        }

        return Response::redirect('/admin/annonces');
    }

    public function update(Request $request): Response
    {
        try {
            $announcement = $this->announcements->update((string) $request->routeParam('id'), [
                'title' => (string) $request->input('title'),
                'body_html' => (string) $request->input('body_html'),
                'visibility' => (string) $request->input('visibility', 'members'),
            ]);
            $this->audit->log($this->session->user() ?? [], 'announcement.update', 'announcement', $request->routeParam('id'), $announcement);
            $this->session->flash('success', 'Annonce modifiee.');
        } catch (\Throwable $e) {
            $this->session->flash('error', $e->getMessage());
        }

        return Response::redirect('/admin/annonces');
    }

    public function archive(Request $request): Response
    {
        try {
            $this->announcements->archive((string) $request->routeParam('id'));
            $this->audit->log($this->session->user() ?? [], 'announcement.archive', 'announcement', $request->routeParam('id'));
            $this->session->flash('success', 'Annonce archivee.');
        } catch (\Throwable $e) {
            $this->session->flash('error', $e->getMessage());
        }

        return Response::redirect('/admin/annonces');
    }
}
