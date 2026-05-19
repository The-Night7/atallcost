<?php $pageTitle = 'Pôles'; ?>
<main class="dashboard-shell">
    <section class="dashboard-hero">
        <p class="section-subtitle">Administration</p>
        <h1>Catalogue des pôles</h1>
        <p>Création, renommage et archivage logique des pôles d'affectation.</p>
    </section>
    <section class="admin-columns">
        <article class="panel-card">
            <h2>Nouveau pôle</h2>
            <form action="/admin/poles" method="post" class="stack-form">
                <input type="hidden" name="_csrf" value="<?= e($csrfToken) ?>">
                <label><span>Nom</span><input type="text" name="name" required></label>
                <button type="submit" class="button-primary">Créer le pôle</button>
            </form>
        </article>
        <article class="panel-card">
            <h2>Pôles existants</h2>
            <div class="user-list">
                <?php foreach ($poles as $pole): ?>
                    <div class="user-item">
                        <div class="user-head">
                            <strong><?= e($pole['name'] ?? '') ?></strong>
                            <span class="status-pill <?= !empty($pole['is_active']) ? 'status-member' : 'status-archived' ?>"><?= !empty($pole['is_active']) ? 'active' : 'archive' ?></span>
                        </div>
                        <p>Slug: <?= e($pole['slug'] ?? '') ?></p>
                        <div class="user-actions">
                            <form action="/admin/poles/<?= e($pole['id'] ?? '') ?>/update" method="post">
                                <input type="hidden" name="_csrf" value="<?= e($csrfToken) ?>">
                                <input type="text" name="name" value="<?= e($pole['name'] ?? '') ?>" required>
                                <button type="submit" class="button-secondary small">Renommer</button>
                            </form>
                            <form action="/admin/poles/<?= e($pole['id'] ?? '') ?>/archive" method="post">
                                <input type="hidden" name="_csrf" value="<?= e($csrfToken) ?>">
                                <button type="submit" class="button-danger small">Archiver</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </article>
    </section>
</main>
