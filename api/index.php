<?php

declare(strict_types=1);

[$request, $router] = require __DIR__ . '/../app/bootstrap.php';

$response = $router->dispatch($request);
$response->send();
