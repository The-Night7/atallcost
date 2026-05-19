<?php

declare(strict_types=1);

namespace App\Support;

use RuntimeException;

final class SupabaseClient
{
    public function __construct(private array $config)
    {
    }

    public function select(string $resource, array $query = [], bool $serviceRole = true): array
    {
        return $this->request('GET', '/rest/v1/' . $resource, $query, null, $serviceRole);
    }

    public function insert(string $resource, array $payload, bool $serviceRole = true): array
    {
        return $this->request('POST', '/rest/v1/' . $resource, [], $payload, $serviceRole, [
            'Prefer: return=representation',
        ]);
    }

    public function update(string $resource, array $payload, array $query, bool $serviceRole = true): array
    {
        return $this->request('PATCH', '/rest/v1/' . $resource, $query, $payload, $serviceRole, [
            'Prefer: return=representation',
        ]);
    }

    public function rpc(string $function, array $payload = [], bool $serviceRole = true): array
    {
        return $this->request('POST', '/rest/v1/rpc/' . $function, [], $payload, $serviceRole);
    }

    public function auth(string $method, string $path, array $query = [], ?array $payload = null, bool $serviceRole = false): array
    {
        return $this->request($method, '/auth/v1/' . ltrim($path, '/'), $query, $payload, $serviceRole);
    }

    public function url(string $path): string
    {
        return $this->config['url'] . $path;
    }

    private function request(
        string $method,
        string $path,
        array $query = [],
        ?array $payload = null,
        bool $serviceRole = true,
        array $extraHeaders = []
    ): array {
        if ($this->config['url'] === '') {
            throw new RuntimeException('SUPABASE_URL manquant');
        }

        $apiKey = $serviceRole ? $this->config['service_role_key'] : $this->config['anon_key'];
        if ($apiKey === '') {
            throw new RuntimeException('Cle Supabase manquante');
        }

        $url = $this->url($path);
        if ($query !== []) {
            $url .= '?' . http_build_query($query, '', '&', PHP_QUERY_RFC3986);
        }

        $ch = curl_init($url);
        $headers = array_merge([
            'apikey: ' . $apiKey,
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
            'Accept: application/json',
        ], $extraHeaders);

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 15,
        ]);

        if ($payload !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload, JSON_THROW_ON_ERROR));
        }

        $raw = curl_exec($ch);
        $httpCode = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($raw === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new RuntimeException($error);
        }
        curl_close($ch);

        if ($raw === '') {
            return [];
        }

        $decoded = json_decode($raw, true);
        if ($httpCode >= 400) {
            $message = is_array($decoded) ? ($decoded['msg'] ?? $decoded['error_description'] ?? $decoded['message'] ?? $raw) : $raw;
            throw new RuntimeException((string) $message, $httpCode);
        }

        return is_array($decoded) ? $decoded : [];
    }
}
