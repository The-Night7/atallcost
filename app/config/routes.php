<?php

declare(strict_types=1);

use App\Controllers\AICodeController;
use App\Controllers\AdminAnnouncementsController;
use App\Controllers\AdminDashboardController;
use App\Controllers\AdminExportsController;
use App\Controllers\AdminPolesController;
use App\Controllers\AdminUsersController;
use App\Controllers\AuthController;
use App\Controllers\MemberController;
use App\Controllers\PublicController;
use App\Http\Router;
use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Middleware\MemberMiddleware;
use App\Support\Container;

return static function (Router $router, Container $container): void {
    $router->get('/', [PublicController::class, 'home']);
    $router->get('/connexion', [AuthController::class, 'showLogin']);
    $router->get('/inscription', [AuthController::class, 'showRegister']);
    $router->get('/attente-validation', [AuthController::class, 'pending'], [AuthMiddleware::class]);
    $router->get('/auth/google/start', [AuthController::class, 'googleStart']);
    $router->get('/auth/google/callback', [AuthController::class, 'googleCallback']);

    $router->post('/auth/register', [AuthController::class, 'register'], [CsrfMiddleware::class]);
    $router->post('/auth/login', [AuthController::class, 'login'], [CsrfMiddleware::class]);
    $router->post('/auth/logout', [AuthController::class, 'logout'], [AuthMiddleware::class, CsrfMiddleware::class]);

    $router->get('/annonces', [MemberController::class, 'announcements'], [AuthMiddleware::class, MemberMiddleware::class]);
    $router->get('/codes-ia', [MemberController::class, 'aiCodes'], [AuthMiddleware::class, MemberMiddleware::class]);
    $router->post('/member/codes-ia/fetch', [AICodeController::class, 'fetch'], [AuthMiddleware::class, MemberMiddleware::class, CsrfMiddleware::class]);

    $router->get('/admin', [AdminDashboardController::class, 'index'], [AuthMiddleware::class, AdminMiddleware::class]);
    $router->get('/admin/utilisateurs', [AdminUsersController::class, 'index'], [AuthMiddleware::class, AdminMiddleware::class]);
    $router->get('/admin/poles', [AdminPolesController::class, 'index'], [AuthMiddleware::class, AdminMiddleware::class]);
    $router->get('/admin/annonces', [AdminAnnouncementsController::class, 'index'], [AuthMiddleware::class, AdminMiddleware::class]);
    $router->get('/admin/requetes-codes', [AdminDashboardController::class, 'requests'], [AuthMiddleware::class, AdminMiddleware::class]);
    $router->get('/admin/exports', [AdminExportsController::class, 'index'], [AuthMiddleware::class, AdminMiddleware::class]);
    $router->get('/admin/exports/stats.csv', [AdminExportsController::class, 'stats'], [AuthMiddleware::class, AdminMiddleware::class]);
    $router->get('/admin/exports/membres.csv', [AdminExportsController::class, 'members'], [AuthMiddleware::class, AdminMiddleware::class]);
    $router->get('/admin/exports/requetes-codes.csv', [AdminExportsController::class, 'requestsCsv'], [AuthMiddleware::class, AdminMiddleware::class]);

    $router->post('/admin/utilisateurs', [AdminUsersController::class, 'store'], [AuthMiddleware::class, AdminMiddleware::class, CsrfMiddleware::class]);
    $router->post('/admin/utilisateurs/{id}/status', [AdminUsersController::class, 'updateStatus'], [AuthMiddleware::class, AdminMiddleware::class, CsrfMiddleware::class]);
    $router->post('/admin/utilisateurs/{id}/poles', [AdminUsersController::class, 'updatePoles'], [AuthMiddleware::class, AdminMiddleware::class, CsrfMiddleware::class]);
    $router->post('/admin/utilisateurs/{id}/archive', [AdminUsersController::class, 'archive'], [AuthMiddleware::class, AdminMiddleware::class, CsrfMiddleware::class]);
    $router->post('/admin/poles', [AdminPolesController::class, 'store'], [AuthMiddleware::class, AdminMiddleware::class, CsrfMiddleware::class]);
    $router->post('/admin/poles/{id}/update', [AdminPolesController::class, 'update'], [AuthMiddleware::class, AdminMiddleware::class, CsrfMiddleware::class]);
    $router->post('/admin/poles/{id}/archive', [AdminPolesController::class, 'archive'], [AuthMiddleware::class, AdminMiddleware::class, CsrfMiddleware::class]);
    $router->post('/admin/annonces', [AdminAnnouncementsController::class, 'store'], [AuthMiddleware::class, AdminMiddleware::class, CsrfMiddleware::class]);
    $router->post('/admin/annonces/{id}/update', [AdminAnnouncementsController::class, 'update'], [AuthMiddleware::class, AdminMiddleware::class, CsrfMiddleware::class]);
    $router->post('/admin/annonces/{id}/archive', [AdminAnnouncementsController::class, 'archive'], [AuthMiddleware::class, AdminMiddleware::class, CsrfMiddleware::class]);
};
