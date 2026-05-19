<?php $pageTitle = 'Inscription'; ?>
<main class="auth-shell">
    <section class="auth-card auth-card-wide">
        <p class="section-subtitle">Adhesion</p>
        <h1>Creer un compte</h1>
        <form action="/auth/register" method="post" class="grid-form">
            <input type="hidden" name="_csrf" value="<?= e($csrfToken) ?>">
            <label><span>Nom</span><input type="text" name="last_name" required></label>
            <label><span>Prenom</span><input type="text" name="first_name" required></label>
            <label><span>Annee d'etude</span><input type="text" name="study_year" required></label>
            <label><span>Date de naissance</span><input type="date" name="birth_date" required></label>
            <label><span>Email</span><input type="email" name="email" required></label>
            <label><span>Telephone</span><input type="tel" name="phone" required></label>
            <label class="span-2"><span>Filiere</span><input type="text" name="major" required></label>
            <label><span>Mot de passe</span><input type="password" name="password" required></label>
            <label><span>Confirmation</span><input type="password" name="password_confirmation" required></label>
            <div class="span-2">
                <button type="submit" class="button-primary button-wide">Envoyer la demande d'adhesion</button>
            </div>
        </form>
        <p class="auth-footnote">Le compte est cree en attente, puis valide par un administrateur.</p>
    </section>
</main>
