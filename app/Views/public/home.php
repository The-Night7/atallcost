<?php $pageTitle = 'Accueil'; ?>
<main>
    <section id="home" class="hero">
        <video autoplay muted loop playsinline class="hero-video">
            <source src="/img_vdo/brain_video.mp4" type="video/mp4">
        </video>
        <div class="hero-overlay"></div>
        <div class="hero-content reveal">
            <p class="eyebrow">CY Tech • Association IA</p>
            <h1>AT ALL <span>COST</span></h1>
            <h2>Intelligence artificielle, experimentation et communaute etudiante</h2>
            <div class="hero-actions">
                <a href="/inscription" class="button-primary">Rejoindre l'association</a>
                <a href="/connexion" class="button-secondary">Espace membre</a>
            </div>
        </div>
        <div class="scroll-down"><i class="fas fa-chevron-down"></i></div>
    </section>

    <section id="about" class="section">
        <div class="section-header reveal">
            <span class="section-subtitle">Qui sommes-nous ?</span>
            <h2 class="section-title">Notre <span>Vision</span></h2>
        </div>
        <div class="vision-container reveal">
            <div class="vision-visual">
                <img src="/img_vdo/brain_neural_network2.png" alt="Illustration intelligence artificielle">
            </div>
            <div class="vision-text">
                <p>At All Cost est un incubateur de talents dedie a l'intelligence artificielle. L'association relie les etudiants aux outils, aux methodes et au reseau necessaires pour transformer une curiosite technique en impact concret.</p>
                <p>Notre mission reste la meme que celle du site d'origine: casser les barrieres academiques, favoriser la pratique et faire monter les membres en competence par des projets, des formations et des evenements utiles.</p>
                <div class="stat-grid">
                    <?php foreach ($highlights as $highlight): ?>
                        <article class="stat-card">
                            <h4><?= e($highlight['title']) ?></h4>
                            <span><?= e($highlight['description']) ?></span>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <section id="team" class="section section-dark">
        <div class="section-header reveal">
            <span class="section-subtitle">La structure</span>
            <h2 class="section-title">L'<span>Organigramme</span></h2>
        </div>
        <div class="org-chart reveal">
            <div class="org-level">
                <article class="member-card card-pres">
                    <span class="role-badge">President</span>
                    <div class="member-name">Asma Kajeiou</div>
                    <div class="member-sub">Strategie & vision</div>
                </article>
                <article class="member-card card-pres">
                    <span class="role-badge">Tresorier</span>
                    <div class="member-name">Lucas Gournier</div>
                    <div class="member-sub">Finances</div>
                </article>
            </div>
            <div class="org-level">
                <article class="member-card">
                    <span class="role-badge">Secretaire</span>
                    <div class="member-name">Dhaker Meddeb</div>
                    <div class="member-sub">Operations</div>
                </article>
                <article class="member-card">
                    <span class="role-badge">Secretaire</span>
                    <div class="member-name">Sanem S</div>
                    <div class="member-sub">Operations</div>
                </article>
            </div>
            <div class="org-level">
                <article class="member-card card-pole">
                    <span class="role-badge">RH</span>
                    <div class="member-name">Myriam Bensaid</div>
                    <div class="member-name">Amira Habes</div>
                    <div class="member-sub">Recrutement & suivi</div>
                </article>
                <article class="member-card card-pole">
                    <span class="role-badge">Com & Design</span>
                    <div class="member-name">Samia Barhili</div>
                    <div class="member-name">Imran El Azri</div>
                    <div class="member-name">Malak Abdou</div>
                    <div class="member-sub">Reseaux & image</div>
                </article>
                <article class="member-card card-pole">
                    <span class="role-badge">Evenementiel</span>
                    <div class="member-name">Yasmina Hida</div>
                    <div class="member-name">Bouchra Zamoum</div>
                    <div class="member-name">Hajar Achour</div>
                    <div class="member-sub">Hackathons & meetups</div>
                </article>
                <article class="member-card card-pole">
                    <span class="role-badge">Relations entreprises</span>
                    <div class="member-name">Tiziri Bouchichene</div>
                    <div class="member-name">Yaasmine Mardak</div>
                    <div class="member-sub">Partenariats</div>
                </article>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-header reveal">
            <span class="section-subtitle">Pourquoi adherer ?</span>
            <h2 class="section-title">Un acces <span>structure</span></h2>
        </div>
        <div class="info-grid reveal">
            <article class="info-card">
                <h3>Annonces internes</h3>
                <p>Les adherents valides accedent aux annonces internes, aux informations d'organisation et aux actualites reservees a l'association.</p>
            </article>
            <article class="info-card">
                <h3>Codes IA</h3>
                <p>Une page membre dediee permet de recuperer les codes IA et les codes de validation via une API, avec journalisation par utilisateur.</p>
            </article>
            <article class="info-card">
                <h3>Pilotage admin</h3>
                <p>Les administrateurs disposent d'un dashboard pour suivre l'evolution des filieres, des annees d'etude, des poles et du volume de requetes.</p>
            </article>
        </div>
    </section>

    <section id="contact" class="section section-panel">
        <div class="contact-container reveal">
            <div class="contact-copy">
                <p class="section-subtitle">Nous rejoindre</p>
                <h2>Construisons le futur ensemble.</h2>
                <p>Inscrivez-vous pour rejoindre At All Cost. Les comptes sont crees en statut <strong>pending</strong>, puis valides par un admin avant l'ouverture des pages membres.</p>
                <div class="contact-meta">
                    <span><i class="fas fa-envelope"></i> atallcostai@gmail.com</span>
                    <span><i class="fas fa-map-marker-alt"></i> Paris, France</span>
                </div>
                <div class="social-links">
                    <a href="https://www.instagram.com/atallcost.ai" target="_blank" rel="noreferrer"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/atallcost/" target="_blank" rel="noreferrer"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://discord.com/invite/eu2X2DqUyR" target="_blank" rel="noreferrer"><i class="fab fa-discord"></i></a>
                </div>
            </div>
            <div class="cta-panel">
                <a href="/inscription" class="button-primary button-wide">Formulaire d'adhesion</a>
                <a href="/connexion" class="button-secondary button-wide">Connexion membre</a>
            </div>
        </div>
    </section>
</main>
