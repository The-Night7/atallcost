<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php $resolvedTitle = $pageTitle ?? ucwords(str_replace(['-', '_'], ' ', basename((string) $view))); ?>
    <title><?= e($appName) ?><?= $resolvedTitle ? ' | ' . e($resolvedTitle) : '' ?></title>
    <link rel="shortcut icon" href="/img/AAC_logo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Rajdhani:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= e(asset('css/app.css')) ?>">
</head>
<body class="<?= e(str_replace('/', '-', trim((string) ($view ?? 'page'), '/'))) ?>">
<header class="site-header">
    <nav class="site-nav">
        <a class="brand" href="/">
            <img src="/img/AAC-logo-2.svg" alt="At All Cost">
        </a>
        <button class="nav-toggle" type="button" data-nav-toggle aria-label="Ouvrir le menu">
            <span></span><span></span><span></span>
        </button>
        <div class="nav-panel" data-nav-panel>
            <a href="/" class="<?= is_active_path('/') ? 'active' : '' ?>">Accueil</a>
            <?php if ($currentUser && in_array($currentUser['status'] ?? '', ['member', 'staff', 'admin'], true)): ?>
                <a href="/annonces" class="<?= is_active_path('/annonces') ? 'active' : '' ?>">Annonces</a>
                <a href="/codes-ia" class="<?= is_active_path('/codes-ia') ? 'active' : '' ?>">Codes IA</a>
            <?php endif; ?>
            <?php if (($currentUser['status'] ?? null) === 'admin'): ?>
                <a href="/admin" class="<?= str_starts_with(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/', '/admin') ? 'active' : '' ?>">Admin</a>
            <?php endif; ?>
            <?php if ($currentUser): ?>
                <form action="/auth/logout" method="post" class="inline-form">
                    <input type="hidden" name="_csrf" value="<?= e($csrfToken) ?>">
                    <button type="submit" class="nav-cta secondary">Deconnexion</button>
                </form>
            <?php else: ?>
                <a href="/connexion">Connexion</a>
                <a href="/inscription" class="nav-cta">Adherer</a>
            <?php endif; ?>
        </div>
    </nav>
</header>

<?php if ($flash): ?>
    <div class="flash flash-<?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
<?php endif; ?>

<?= $content ?>

<footer class="site-footer">
    <div class="footer-brand">
        <img src="/img/AAC-logo-2.svg" alt="AAC">
        <p>At All Cost AI Lab</p>
    </div>
    <p>&copy; 2024 At All Cost. Association etudiante orientee IA, innovation et projets concrets.</p>
</footer>

<script>
window.AT_ALL_COST = {
    csrfToken: <?= json_encode($csrfToken, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR) ?>
};
</script>
<script src="<?= e(asset('js/app.js')) ?>" defer></script>
<?php if (str_starts_with($view ?? '', 'admin/')): ?>
    <script src="<?= e(asset('js/admin.js')) ?>" defer></script>
<?php endif; ?>
</body>
</html>
