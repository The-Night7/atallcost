# Structure et Design du Site Web - At All Cost

## Architecture générale

### Pages principales
1. **Accueil** : Présentation de l'association, call-to-action vers inscription
2. **À Propos** : Présentation détaillée, valeurs, missions
3. **Équipe/Bureau** : Fiches des postes, rôles, responsabilités
4. **Événements** : Calendrier des activités (à étendre)
5. **Inscription** : Formulaire d'adhésion avec envoi email
6. **Ressources** : Règles d'utilisation, documents internes (optionnel)
7. **Contact/Liens** : Réseaux sociaux, formulaire de contact

## Design et Styling

### Palette de Couleurs
- **Couleur primaire** : Bleu moderne (pour l'IA/tech) - #0066FF ou #1E40AF
- **Couleur secondaire** : Accent blanc/gris clair - #F8F9FA
- **Couleur tertiaire** : Accent moderne - #00D9FF ou #10B981 (vert tech)
- **Texte** : Gris foncé/noir - #1F2937

### Typographie
- **Titre principal** : Montserrat, Poppins (moderne, sans-serif)
- **Corps** : Inter, Roboto (lisible, professionnelle)

### Branding & Visuels
- Utiliser des éléments IA/tech (circuits, graphiques, grilles)
- Logo de l'association (si disponible)
- Images d'équipe, événements (si disponibles)
- Icônes pour les réseaux sociaux

## Sections de la Page d'Accueil

### 1. Hero Section
- Titre accrocheur : "At All Cost - L'AI Lab de CY Tech"
- Sous-titre descriptif
- Bouton CTA : "Nous Rejoindre"
- Image/vidéo de fond

### 2. Présentation Rapide
- 3-4 points clés sur l'association
- Formation, Événements, Collaboration, Innovation

### 3. Section Réseaux Sociaux
- Liens vers tous les réseaux (Discord, Telegram, Instagram, LinkedIn, LinkTree)
- Icônes visibles, accessibles

### 4. Équipe/Rôles
- Mini-affichage des postes clés
- Lien vers page détaillée

### 5. Inscription
- Formulaire intégré ou lien vers page dédiée
- Email de destination : atallcostai@gmail.com

### 6. Footer
- Liens rapides
- Email de contact
- Copyright et liens sociaux

## Page Formulaire d'Inscription

### Champs
- Nom complet
- Email
- Numéro de téléphone (optionnel)
- Année d'études / Cursus
- Domaines d'intérêt (checkbox multiple)
- Message/Motivation (textarea)
- Conditions d'utilisation (checkbox)

### Fonctionnalité
- Validation côté client et serveur
- Envoi des données par email à atallcostai@gmail.com
- Confirmation utilisateur après envoi
- Stockage optionnel en base de données

## Responsive Design
- Mobile-first approach
- Breakpoints : 320px, 768px, 1024px, 1280px
- Navigation responsive (menu hamburger sur mobile)
- Images adaptatives

## Performance & SEO
- Optimisation des images
- Lazy loading
- Minification CSS/JavaScript
- Meta tags (description, keywords)
- Heading hierarchy (h1, h2, h3...)

## Accessibilité
- Contraste WCAG AAA
- Alt text pour toutes les images
- Navigation au clavier
- ARIA labels où nécessaire
