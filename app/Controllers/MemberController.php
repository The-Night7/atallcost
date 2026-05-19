<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Repositories\AICodeRequestRepository;
use App\Services\AnnouncementService;
use App\Services\SessionService;
use App\Support\View;

final class MemberController
{
    public function __construct(
        private View $view,
        private AnnouncementService $announcements,
        private SessionService $session,
        private AICodeRequestRepository $requests
    ) {
    }

    public function announcements(Request $request): Response
    {
        return $this->view->make('member/announcements', [
            'announcements' => $this->announcements->visibleToMembers(),
        ]);
    }

    public function aiCodes(Request $request): Response
    {
        $user = $this->session->user();

        return $this->view->make('member/ai-codes', [
            'history' => $user ? $this->requests->forUser($user['id']) : [],
        ]);
    }
}
