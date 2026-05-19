<?php $pageTitle = 'Annonces internes'; ?>
<main class="dashboard-shell">
    <section class="dashboard-hero">
        <p class="section-subtitle">Reserve adherents+</p>
        <h1>Annonces internes</h1>
        <p>Informations reservees aux membres valides de l'association.</p>
    </section>
    <section class="cards-grid">
        <?php foreach ($announcements as $announcement): ?>
            <article class="panel-card">
                <div class="panel-meta"><?= e(date('d/m/Y', strtotime($announcement['published_at'] ?? 'now'))) ?></div>
                <h2><?= e($announcement['title'] ?? 'Annonce') ?></h2>
                <div class="rich-text"><?= $announcement['body_html'] ?? '' ?></div>
            </article>
        <?php endforeach; ?>
        <?php if ($announcements === []): ?>
            <article class="panel-card">
                <h2>Aucune annonce publiee</h2>
                <p>Les annonces internes creeront le flux d'information membre des que l'espace admin sera alimente.</p>
            </article>
        <?php endif; ?>
    </section>
</main>
