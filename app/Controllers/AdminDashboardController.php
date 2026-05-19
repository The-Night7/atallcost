<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Repositories\AICodeRequestRepository;
use App\Services\AnalyticsService;
use App\Support\View;

final class AdminDashboardController
{
    public function __construct(
        private View $view,
        private AnalyticsService $analytics,
        private AICodeRequestRepository $requests
    ) {
    }

    public function index(Request $request): Response
    {
        return $this->view->make('admin/dashboard', [
            'dashboard' => $this->analytics->dashboard(),
        ]);
    }

    public function requests(Request $request): Response
    {
        return $this->view->make('admin/code-requests', [
            'requests' => $this->requests->all(),
        ]);
    }
}
