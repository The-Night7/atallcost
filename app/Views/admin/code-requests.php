<?php $pageTitle = 'Requêtes codes'; ?>
<main class="dashboard-shell">
    <section class="dashboard-hero">
        <p class="section-subtitle">Administration</p>
        <h1>Journal des requêtes codes IA</h1>
        <p>Chaque ligne est rattachée à l'utilisateur qui a demandé ses codes.</p>
    </section>
    <section class="panel-card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Utilisateur</th>
                    <th>Provider</th>
                    <th>Statut</th>
                    <th>Code IA</th>
                    <th>Code validation</th>
                    <th>HTTP</th>
                    <th>Cumul</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($requests as $row): ?>
                    <tr>
                        <td><?= e(date('d/m/Y H:i', strtotime($row['requested_at'] ?? 'now'))) ?></td>
                        <td><?= e(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? '')) ?></td>
                        <td><?= e($row['provider'] ?? '') ?></td>
                        <td><?= e($row['request_status'] ?? '') ?></td>
                        <td><?= e($row['ai_code_masked'] ?? '') ?></td>
                        <td><?= e($row['validation_code_masked'] ?? '') ?></td>
                        <td><?= e((string) ($row['http_status'] ?? '')) ?></td>
                        <td><?= e((string) ($row['request_count'] ?? 1)) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>
