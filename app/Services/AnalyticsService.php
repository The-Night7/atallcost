<?php

declare(strict_types=1);

namespace App\Services;

use App\Support\SupabaseClient;

final class AnalyticsService
{
    public function __construct(private SupabaseClient $supabase)
    {
    }

    public function dashboard(): array
    {
        $summary = $this->firstOrDefault($this->supabase->select('v_dashboard_summary', ['select' => '*']));
        $majors = $this->supabase->select('v_members_by_major', ['select' => '*', 'order' => 'members.desc']);
        $studyYears = $this->supabase->select('v_members_by_study_year', ['select' => '*', 'order' => 'study_year.asc']);
        $poles = $this->supabase->select('v_pole_population_rates', ['select' => '*', 'order' => 'members_count.desc']);
        $topRequesters = $this->supabase->select('v_ai_code_requests_per_user', ['select' => '*', 'order' => 'request_count.desc', 'limit' => '10']);

        return compact('summary', 'majors', 'studyYears', 'poles', 'topRequesters');
    }

    private function firstOrDefault(array $rows): array
    {
        return $rows[0] ?? [
            'total_members' => 0,
            'total_requests' => 0,
            'total_poles' => 0,
        ];
    }
}
