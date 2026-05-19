<?php $pageTitle = 'Exports CSV'; ?>
<main class="dashboard-shell">
    <section class="dashboard-hero">
        <p class="section-subtitle">Administration</p>
        <h1>Exports CSV</h1>
        <p>Téléchargement des agrégats dashboard, de l'annuaire des membres et du journal des requêtes.</p>
    </section>
    <section class="cards-grid">
        <article class="panel-card">
            <h2>Statistiques agrégées</h2>
            <p>Total adhérents, répartition par filière, années d'étude et taux de population des pôles.</p>
            <a href="/admin/exports/stats.csv" class="button-primary">Télécharger</a>
        </article>
        <article class="panel-card">
            <h2>Annuaire membres</h2>
            <p>Données de gestion nécessaires à l'administration des adhérents actifs.</p>
            <a href="/admin/exports/membres.csv" class="button-primary">Télécharger</a>
        </article>
        <article class="panel-card">
            <h2>Logs requêtes codes</h2>
            <p>Historique des appels, statuts, providers et volumes par utilisateur.</p>
            <a href="/admin/exports/requetes-codes.csv" class="button-primary">Télécharger</a>
        </article>
    </section>
</main>
