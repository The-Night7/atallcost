<?php

declare(strict_types=1);

namespace App\Support;

use App\Http\Response;

final class View
{
    public function __construct(
        private array $config,
        private Container $container
    ) {
    }

    public function make(string $view, array $data = [], ?string $layout = null): Response
    {
        $globals = ($this->config['globals'])($this->container);
        $payload = array_merge($globals, $data);
        $content = $this->renderFile($view, $payload);

        $layout ??= $this->config['layout'];
        $html = $this->renderFile($layout, array_merge($payload, [
            'content' => $content,
            'view' => $view,
        ]));

        return Response::html($html);
    }

    private function renderFile(string $template, array $data): string
    {
        $path = __DIR__ . '/../Views/' . $template . '.php';
        if (!is_file($path)) {
            throw new \RuntimeException("Vue introuvable: {$template}");
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $path;
        return (string) ob_get_clean();
    }
}
