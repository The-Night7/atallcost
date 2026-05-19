<?php

declare(strict_types=1);

namespace App\Http;

use App\Support\Container;

final class Request
{
    private ?Container $container = null;

    public function __construct(
        private string $method,
        private string $path,
        private array $query,
        private array $body,
        private array $server,
        private array $files,
        private array $cookies,
        private array $session
    ) {
    }

    public static function capture(): self
    {
        $path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $body = $_POST;
        if ($body === []) {
            $json = file_get_contents('php://input');
            $decoded = json_decode($json ?: '[]', true);
            if (is_array($decoded)) {
                $body = $decoded;
            }
        }

        return new self(
            strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET'),
            $path,
            $_GET,
            $body,
            $_SERVER,
            $_FILES,
            $_COOKIE,
            $_SESSION ?? []
        );
    }

    public function setContainer(Container $container): void
    {
        $this->container = $container;
        $GLOBALS['container'] = $container;
    }

    public function container(): Container
    {
        return $this->container ?? throw new \RuntimeException('Container absent');
    }

    public function method(): string
    {
        return $this->method;
    }

    public function path(): string
    {
        return $this->path;
    }

    public function query(string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->query;
        }

        return $this->query[$key] ?? $default;
    }

    public function input(string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->body;
        }

        return $this->body[$key] ?? $default;
    }

    public function server(string $key, mixed $default = null): mixed
    {
        return $this->server[$key] ?? $default;
    }

    public function all(): array
    {
        return $this->body;
    }

    public function expectsJson(): bool
    {
        return str_contains((string) ($this->server['HTTP_ACCEPT'] ?? ''), 'application/json');
    }

    public function routeParam(string $key, mixed $default = null): mixed
    {
        return $this->server['_route_params'][$key] ?? $default;
    }
}
