<?php $pageTitle = 'Dashboard admin'; ?>
<?php $summary = $dashboard['summary'] ?? []; ?>
<main class="dashboard-shell">
    <section class="dashboard-hero">
        <p class="section-subtitle">Administration</p>
        <h1>Dashboard association</h1>
        <p>Vue agrégée sur les membres, les pôles et les requêtes de récupération de codes IA.</p>
    </section>
    <section class="kpi-grid">
        <article class="kpi-card"><span>Total adhérents</span><strong><?= e((string) ($summary['total_members'] ?? 0)) ?></strong></article>
        <article class="kpi-card"><span>Total requêtes codes</span><strong><?= e((string) ($summary['total_requests'] ?? 0)) ?></strong></article>
        <article class="kpi-card"><span>Nombre de pôles</span><strong><?= e((string) ($summary['total_poles'] ?? 0)) ?></strong></article>
    </section>
    <section class="charts-grid">
        <article class="panel-card chart-card" data-chart='<?= json_encode($dashboard['majors'] ?? [], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR) ?>'>
            <h2>Répartition par filière</h2>
            <div class="chart-bars" data-chart-target></div>
        </article>
        <article class="panel-card chart-card" data-chart='<?= json_encode($dashboard['studyYears'] ?? [], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR) ?>'>
            <h2>Répartition par année d'étude</h2>
            <div class="chart-bars" data-chart-target></div>
        </article>
        <article class="panel-card chart-card" data-chart='<?= json_encode($dashboard['poles'] ?? [], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR) ?>'>
            <h2>Taux de population par pôle</h2>
            <div class="chart-bars" data-chart-target></div>
        </article>
        <article class="panel-card">
            <h2>Top utilisateurs par requêtes</h2>
            <table class="data-table">
                <thead><tr><th>Utilisateur</th><th>Requêtes</th></tr></thead>
                <tbody>
                    <?php foreach (($dashboard['topRequesters'] ?? []) as $row): ?>
                        <tr>
                            <td><?= e(($row['first_name'] ?? '') . ' ' . ($row['last_name'] ?? '')) ?></td>
                            <td><?= e((string) ($row['request_count'] ?? 0)) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </article>
    </section>
</main>
