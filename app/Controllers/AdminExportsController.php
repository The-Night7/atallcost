<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;
use App\Services\AdminAuditService;
use App\Services\CsvExportService;
use App\Services\SessionService;
use App\Support\View;

final class AdminExportsController
{
    public function __construct(
        private View $view,
        private CsvExportService $csv,
        private SessionService $session,
        private AdminAuditService $audit
    ) {
    }

    public function index(Request $request): Response
    {
        return $this->view->make('admin/exports');
    }

    public function stats(Request $request): Response
    {
        $this->audit->log($this->session->user() ?? [], 'export.stats', 'csv', 'stats');
        return Response::csv('stats-atallcost.csv', $this->csv->statsCsv());
    }

    public function members(Request $request): Response
    {
        $this->audit->log($this->session->user() ?? [], 'export.members', 'csv', 'members');
        return Response::csv('membres-atallcost.csv', $this->csv->membersCsv());
    }

    public function requestsCsv(Request $request): Response
    {
        $this->audit->log($this->session->user() ?? [], 'export.requests', 'csv', 'requests');
        return Response::csv('requetes-codes-atallcost.csv', $this->csv->requestsCsv());
    }
}
