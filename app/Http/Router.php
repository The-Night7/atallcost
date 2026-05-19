<?php

declare(strict_types=1);

namespace App\Http;

use App\Support\Container;

final class Router
{
    private array $routes = [];

    public function __construct(private Container $container)
    {
    }

    public function get(string $path, array $handler, array $middlewares = []): void
    {
        $this->add('GET', $path, $handler, $middlewares);
    }

    public function post(string $path, array $handler, array $middlewares = []): void
    {
        $this->add('POST', $path, $handler, $middlewares);
    }

    public function add(string $method, string $path, array $handler, array $middlewares = []): void
    {
        $this->routes[] = compact('method', 'path', 'handler', 'middlewares');
    }

    public function dispatch(Request $request): Response
    {
        foreach ($this->routes as $route) {
            if ($route['method'] !== $request->method()) {
                continue;
            }

            $pattern = preg_replace('#\{([^/]+)\}#', '(?P<$1>[^/]+)', $route['path']);
            if (!preg_match('#^' . $pattern . '$#', $request->path(), $matches)) {
                continue;
            }

            $params = array_filter($matches, static fn ($key) => !is_int($key), ARRAY_FILTER_USE_KEY);
            $_SERVER['_route_params'] = $params;

            $core = function (Request $request) use ($route): Response {
                [$class, $method] = $route['handler'];
                $controller = $this->container->get($class);
                return $controller->{$method}($request);
            };

            $pipeline = array_reduce(
                array_reverse($route['middlewares']),
                function (callable $next, string $middleware): callable {
                    return function (Request $request) use ($middleware, $next): Response {
                        $instance = $this->container->get($middleware);
                        return $instance->handle($request, $next);
                    };
                },
                $core
            );

            return $pipeline($request);
        }

        return Response::html('<h1>404</h1><p>Page introuvable.</p>', 404);
    }
}
