<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\AICodeRequestRepository;

final class CsvExportService
{
    public function __construct(
        private ProfileService $profiles,
        private AnalyticsService $analytics,
        private AICodeRequestRepository $requests
    ) {
    }

    public function statsCsv(): string
    {
        $dashboard = $this->analytics->dashboard();
        $rows = [['metric', 'value']];
        foreach ($dashboard['summary'] as $key => $value) {
            $rows[] = [$key, (string) $value];
        }

        foreach ($dashboard['majors'] as $row) {
            $rows[] = ['major:' . ($row['major'] ?? 'NC'), (string) ($row['members'] ?? 0)];
        }

        foreach ($dashboard['studyYears'] as $row) {
            $rows[] = ['study_year:' . ($row['study_year'] ?? 'NC'), (string) ($row['members'] ?? 0)];
        }

        foreach ($dashboard['poles'] as $row) {
            $rows[] = ['pole:' . ($row['name'] ?? 'NC'), (string) ($row['population_rate'] ?? 0)];
        }

        return $this->toCsv($rows);
    }

    public function membersCsv(): string
    {
        $rows = [[
            'first_name', 'last_name', 'email', 'study_year', 'birth_date', 'phone', 'major', 'status',
        ]];
        foreach ($this->profiles->activeMembersDirectory() as $member) {
            $rows[] = [
                $member['first_name'] ?? '',
                $member['last_name'] ?? '',
                $member['email'] ?? '',
                $member['study_year'] ?? '',
                $member['birth_date'] ?? '',
                $member['phone'] ?? '',
                $member['major'] ?? '',
                $member['status'] ?? '',
            ];
        }

        return $this->toCsv($rows);
    }

    public function requestsCsv(): string
    {
        $rows = [[
            'requested_at', 'email', 'provider', 'request_status', 'ai_code_masked', 'validation_code_masked', 'http_status',
        ]];
        foreach ($this->requests->all() as $row) {
            $rows[] = [
                $row['requested_at'] ?? '',
                $row['email'] ?? '',
                $row['provider'] ?? '',
                $row['request_status'] ?? '',
                $row['ai_code_masked'] ?? '',
                $row['validation_code_masked'] ?? '',
                (string) ($row['http_status'] ?? ''),
            ];
        }

        return $this->toCsv($rows);
    }

    private function toCsv(array $rows): string
    {
        $handle = fopen('php://temp', 'r+');
        foreach ($rows as $row) {
            fputcsv($handle, $row, ';');
        }
        rewind($handle);
        return (string) stream_get_contents($handle);
    }
}
