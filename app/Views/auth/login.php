<?php $pageTitle = 'Connexion'; ?>
<main class="auth-shell">
    <section class="auth-card">
        <p class="section-subtitle">Espace membre</p>
        <h1>Connexion</h1>
        <p class="auth-intro">Acces par email/mot de passe ou Google. Les pages sensibles restent reservees aux statuts <code>member</code>, <code>staff</code> et <code>admin</code>.</p>
        <form action="/auth/login" method="post" class="stack-form">
            <input type="hidden" name="_csrf" value="<?= e($csrfToken) ?>">
            <label>
                <span>Email</span>
                <input type="email" name="email" required>
            </label>
            <label>
                <span>Mot de passe</span>
                <input type="password" name="password" required>
            </label>
            <button type="submit" class="button-primary">Se connecter</button>
        </form>
        <a href="/auth/google/start" class="button-google"><i class="fab fa-google"></i> Continuer avec Google</a>
        <p class="auth-footnote">Pas encore inscrit ? <a href="/inscription">Creer un compte</a></p>
    </section>
</main>
