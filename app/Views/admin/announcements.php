<?php $pageTitle = 'Annonces'; ?>
<main class="dashboard-shell">
    <section class="dashboard-hero">
        <p class="section-subtitle">Administration</p>
        <h1>Annonces internes</h1>
        <p>Créer et maintenir le flux d'information visible sur l'espace membre.</p>
    </section>
    <section class="admin-columns">
        <article class="panel-card">
            <h2>Nouvelle annonce</h2>
            <form action="/admin/annonces" method="post" class="stack-form">
                <input type="hidden" name="_csrf" value="<?= e($csrfToken) ?>">
                <label><span>Titre</span><input type="text" name="title" required></label>
                <label><span>Visibilité</span>
                    <select name="visibility">
                        <option value="members">members</option>
                        <option value="staff">staff</option>
                        <option value="admins">admins</option>
                    </select>
                </label>
                <label><span>Contenu HTML</span><textarea name="body_html" rows="8" required></textarea></label>
                <button type="submit" class="button-primary">Publier</button>
            </form>
        </article>
        <article class="panel-card">
            <h2>Liste des annonces</h2>
            <div class="user-list">
                <?php foreach ($announcements as $announcement): ?>
                    <div class="user-item">
                        <div class="user-head">
                            <strong><?= e($announcement['title'] ?? '') ?></strong>
                            <span class="status-pill status-member"><?= e($announcement['visibility'] ?? 'members') ?></span>
                        </div>
                        <div class="rich-text compact-text"><?= $announcement['body_html'] ?? '' ?></div>
                        <div class="user-actions">
                            <form action="/admin/annonces/<?= e($announcement['id'] ?? '') ?>/update" method="post" class="stack-form">
                                <input type="hidden" name="_csrf" value="<?= e($csrfToken) ?>">
                                <input type="text" name="title" value="<?= e($announcement['title'] ?? '') ?>" required>
                                <select name="visibility">
                                    <?php foreach (['members', 'staff', 'admins'] as $visibility): ?>
                                        <option value="<?= e($visibility) ?>" <?= ($announcement['visibility'] ?? '') === $visibility ? 'selected' : '' ?>><?= e($visibility) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <textarea name="body_html" rows="5" required><?= e($announcement['body_html'] ?? '') ?></textarea>
                                <button type="submit" class="button-secondary small">Mettre à jour</button>
                            </form>
                            <form action="/admin/annonces/<?= e($announcement['id'] ?? '') ?>/archive" method="post">
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
