<?php

declare(strict_types=1);

use App\Http\Request;
use App\Http\Router;
use App\Services\AICodeProviderInterface;
use App\Services\AdminAuditService;
use App\Services\AnalyticsService;
use App\Services\AnnouncementService;
use App\Services\CsvExportService;
use App\Services\ExternalAICodeProvider;
use App\Services\PoleService;
use App\Services\ProfileService;
use App\Services\SessionService;
use App\Services\StubAICodeProvider;
use App\Services\SupabaseAuthService;
use App\Support\Container;
use App\Support\Env;
use App\Support\SupabaseClient;
use App\Support\View;

require_once __DIR__ . '/Support/helpers.php';

spl_autoload_register(static function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $relative = substr($class, strlen($prefix));
    $path = __DIR__ . '/' . str_replace('\\', '/', $relative) . '.php';
    if (is_file($path)) {
        require_once $path;
    }
});

Env::load(dirname(__DIR__) . '/.env');

$config = [
    'app' => [
        'name' => env('APP_NAME', 'At All Cost'),
        'env' => env('APP_ENV', 'production'),
        'debug' => filter_var(env('APP_DEBUG', 'false'), FILTER_VALIDATE_BOOL),
        'url' => rtrim(env('APP_URL', 'http://localhost:8000'), '/'),
    ],
    'session' => [
        'name' => env('SESSION_NAME', 'atallcost_session'),
        'secure' => filter_var(env('SESSION_SECURE_COOKIE', 'false'), FILTER_VALIDATE_BOOL),
        'samesite' => env('SESSION_SAMESITE', 'Lax'),
    ],
    'supabase' => [
        'url' => rtrim((string) env('SUPABASE_URL', ''), '/'),
        'anon_key' => (string) env('SUPABASE_ANON_KEY', ''),
        'service_role_key' => (string) env('SUPABASE_SERVICE_ROLE_KEY', ''),
    ],
    'google' => [
        'redirect_uri' => (string) env('GOOGLE_REDIRECT_URI', ''),
    ],
    'ai_codes' => [
        'mode' => env('AI_CODE_PROVIDER_MODE', 'stub'),
        'provider_name' => env('AI_CODE_PROVIDER_NAME', 'default'),
        'api_url' => env('AI_CODE_API_URL', ''),
        'api_key' => env('AI_CODE_API_KEY', ''),
        'timeout' => (int) env('AI_CODE_API_TIMEOUT', '10'),
    ],
];

session_name($config['session']['name']);
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'secure' => $config['session']['secure'],
    'httponly' => true,
    'samesite' => $config['session']['samesite'],
]);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$container = new Container();
$container->set('config', $config);
$container->set(Container::class, $container);
$container->set(SessionService::class, static fn () => new SessionService());
$container->set(SupabaseClient::class, static fn () => new SupabaseClient($config['supabase']));
$container->set(View::class, static fn (Container $c) => new View(require __DIR__ . '/config/view.php', $c));
$container->set(ProfileService::class, static fn (Container $c) => new ProfileService(
    $c->get(\App\Repositories\ProfileRepository::class),
    $c->get(\App\Repositories\PoleRepository::class)
));
$container->set(PoleService::class, static fn (Container $c) => new PoleService($c->get(\App\Repositories\PoleRepository::class)));
$container->set(AnnouncementService::class, static fn (Container $c) => new AnnouncementService($c->get(\App\Repositories\AnnouncementRepository::class)));
$container->set(AdminAuditService::class, static fn (Container $c) => new AdminAuditService($c->get(SupabaseClient::class)));
$container->set(AnalyticsService::class, static fn (Container $c) => new AnalyticsService($c->get(SupabaseClient::class)));
$container->set(CsvExportService::class, static fn (Container $c) => new CsvExportService(
    $c->get(ProfileService::class),
    $c->get(AnalyticsService::class),
    $c->get(\App\Repositories\AICodeRequestRepository::class)
));
$container->set(AICodeProviderInterface::class, static fn (Container $c) => $config['ai_codes']['mode'] === 'external'
    ? new ExternalAICodeProvider($config['ai_codes'])
    : new StubAICodeProvider($config['ai_codes']));
$container->set(SupabaseAuthService::class, static fn (Container $c) => new SupabaseAuthService(
    $c->get(SupabaseClient::class),
    $c->get(SessionService::class),
    $c->get(ProfileService::class),
    $config
));
$container->set(\App\Repositories\ProfileRepository::class, static fn (Container $c) => new \App\Repositories\ProfileRepository($c->get(SupabaseClient::class)));
$container->set(\App\Repositories\PoleRepository::class, static fn (Container $c) => new \App\Repositories\PoleRepository($c->get(SupabaseClient::class)));
$container->set(\App\Repositories\AnnouncementRepository::class, static fn (Container $c) => new \App\Repositories\AnnouncementRepository($c->get(SupabaseClient::class)));
$container->set(\App\Repositories\AICodeRequestRepository::class, static fn (Container $c) => new \App\Repositories\AICodeRequestRepository($c->get(SupabaseClient::class)));

$request = Request::capture();
$request->setContainer($container);

$router = new Router($container);
(require __DIR__ . '/config/routes.php')($router, $container);

return [$request, $router];
