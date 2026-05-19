<?php $pageTitle = 'Utilisateurs'; ?>
<main class="dashboard-shell">
    <section class="dashboard-hero">
        <p class="section-subtitle">Administration</p>
        <h1>Gestion des utilisateurs</h1>
        <p>Les données personnelles restent visibles uniquement dans cette vue d'administration.</p>
    </section>
    <section class="admin-columns">
        <article class="panel-card">
            <h2>Créer un utilisateur</h2>
            <form action="/admin/utilisateurs" method="post" class="grid-form compact">
                <input type="hidden" name="_csrf" value="<?= e($csrfToken) ?>">
                <label><span>Nom</span><input type="text" name="last_name" required></label>
                <label><span>Prénom</span><input type="text" name="first_name" required></label>
                <label><span>Année</span><input type="text" name="study_year" required></label>
                <label><span>Naissance</span><input type="date" name="birth_date" required></label>
                <label><span>Email</span><input type="email" name="email" required></label>
                <label><span>Téléphone</span><input type="text" name="phone" required></label>
                <label class="span-2"><span>Filière</span><input type="text" name="major" required></label>
                <label><span>Mot de passe</span><input type="password" name="password" required></label>
                <label><span>Confirmation</span><input type="password" name="password_confirmation" required></label>
                <div class="span-2"><button type="submit" class="button-primary button-wide">Créer</button></div>
            </form>
        </article>
        <article class="panel-card">
            <h2>Annuaire administrable</h2>
            <div class="user-list">
                <?php foreach ($profiles as $profile): ?>
                    <div class="user-item">
                        <div class="user-head">
                            <strong><?= e(($profile['first_name'] ?? '') . ' ' . ($profile['last_name'] ?? '')) ?></strong>
                            <span class="status-pill status-<?= e($profile['status'] ?? 'pending') ?>"><?= e($profile['status'] ?? 'pending') ?></span>
                        </div>
                        <p><?= e($profile['email'] ?? '') ?> · <?= e($profile['phone'] ?? '') ?></p>
                        <p><?= e($profile['major'] ?? '') ?> · <?= e($profile['study_year'] ?? '') ?></p>
                        <p>Pôles: <?= e(implode(', ', array_map(static fn ($pole) => $pole['name'] ?? '', $profile['poles'] ?? []))) ?></p>
                        <div class="user-actions">
                            <form action="/admin/utilisateurs/<?= e($profile['id'] ?? '') ?>/status" method="post">
                                <input type="hidden" name="_csrf" value="<?= e($csrfToken) ?>">
                                <select name="status">
                                    <?php foreach (['pending', 'member', 'staff', 'admin', 'archived'] as $status): ?>
                                        <option value="<?= e($status) ?>" <?= ($profile['status'] ?? '') === $status ? 'selected' : '' ?>><?= e($status) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="button-secondary small">Mettre à jour</button>
                            </form>
                            <form action="/admin/utilisateurs/<?= e($profile['id'] ?? '') ?>/poles" method="post">
                                <input type="hidden" name="_csrf" value="<?= e($csrfToken) ?>">
                                <select name="pole_ids[]" multiple>
                                    <?php $assigned = array_column($profile['poles'] ?? [], 'id'); ?>
                                    <?php foreach ($poles as $pole): ?>
                                        <option value="<?= e($pole['id'] ?? '') ?>" <?= in_array($pole['id'] ?? null, $assigned, true) ? 'selected' : '' ?>><?= e($pole['name'] ?? '') ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="button-secondary small">Enregistrer les pôles</button>
                            </form>
                            <form action="/admin/utilisateurs/<?= e($profile['id'] ?? '') ?>/archive" method="post">
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
