<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\AnnouncementService;
use App\Support\View;

final class PublicController
{
    public function __construct(
        private View $view,
        private AnnouncementService $announcements
    ) {
    }

    public function home(Request $request): Response
    {
        return $this->view->make('public/home', [
            'highlights' => $this->announcements->publicLandingHighlights(),
        ]);
    }
}
