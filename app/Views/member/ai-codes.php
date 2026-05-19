<?php $pageTitle = 'Codes IA'; ?>
<main class="dashboard-shell">
    <section class="dashboard-hero">
        <p class="section-subtitle">API adherents+</p>
        <h1>Recuperation des codes IA</h1>
        <p>Chaque requete est journalisee et rattachee a votre utilisateur.</p>
    </section>
    <section class="ai-layout">
        <article class="panel-card ai-request-card">
            <h2>Demander un code</h2>
            <p>Le provider actif est appele en temps reel a chaque demande.</p>
            <button class="button-primary" data-ai-code-fetch data-endpoint="/member/codes-ia/fetch">Recuperer les codes</button>
            <div class="code-box" data-ai-code-result>
                <p class="code-placeholder">Les codes apparaitront ici.</p>
            </div>
        </article>
        <article class="panel-card">
            <h2>Historique recent</h2>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Provider</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history as $row): ?>
                        <tr>
                            <td><?= e(date('d/m/Y H:i', strtotime($row['requested_at'] ?? 'now'))) ?></td>
                            <td><?= e($row['request_status'] ?? '') ?></td>
                            <td><?= e($row['provider'] ?? '') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if ($history === []): ?>
                        <tr><td colspan="3">Aucune requete pour le moment.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </article>
    </section>
</main>
