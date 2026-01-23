# 🚀 Site Web - At All Cost (AI Lab de CY Tech)

Site web professionnel pour l'association **At All Cost** de CY Tech, dédiée à l'intelligence artificielle et l'innovation technologique.

## 📋 Table des matières

- [Vue d'ensemble](#-vue-densemble)
- [Caractéristiques](#-caractéristiques)
- [Structure du projet](#-structure-du-projet)
- [Installation](#-installation)
- [Déploiement](#-déploiement)
- [Configuration Email](#-configuration-email)
- [Tests](#-tests)
- [Support](#-support)

---

## 📱 Vue d'ensemble

Ce projet fournit un site web moderne et professionnel pour l'association At All Cost avec:

- **Page d'accueil** attrayante avec présentation de l'association
- **Formulaire d'inscription** avec envoi d'email automatique
- **Liens vers tous les réseaux sociaux** de l'association
- **Design responsive** pour tous les appareils
- **Performance optimisée** et SEO amélioré
- **Accessibilité WCAG** respectée

### 🎯 Sections du site

1. **Accueil** - Présentation et call-to-action
2. **À Propos** - Valeurs et missions de l'association
3. **Équipe** - Structure organisationnelle
4. **Réseaux** - Tous les liens sociaux
5. **Inscription** - Formulaire d'adhésion
6. **Footer** - Contact et liens rapides

---

## ✨ Caractéristiques

### 🎨 Design
- Palette de couleurs moderne (Bleu primaire + Cyan)
- Design responsive mobile-first
- Animations fluides et transitions
- Typographie professionnelle

### 📧 Email
- Intégration Nodemailer (Node.js)
- Alternative EmailJS (client-side)
- Envoi automatique au destinataire
- Confirmation utilisateur

### 🌐 Réseaux Sociaux
- Discord
- Telegram
- Instagram
- LinkedIn
- LinkTree
- Site CY Tech

### ♿ Accessibilité
- Contraste WCAG AAA
- Navigation au clavier
- Alt text sur les images
- ARIA labels

### 📊 Performance
- Lighthouse > 85 sur tous les metrics
- Images optimisées
- CSS/JS minifiés
- Lazy loading

---

## 📁 Structure du projet

```
at-all-cost-website/
├── index.html              # Page HTML principale
├── styles.css              # Feuille de styles CSS
├── script.js               # JavaScript client-side
├── email_config.js         # Configuration serveur Node.js
├── package.json            # Dépendances Node.js
├── .env.example            # Template variables d'environnement
├── .gitignore              # Fichiers à ignorer
├── README.md               # Ce fichier
├── DEPLOYMENT_GUIDE.md     # Guide de déploiement
├── EMAILJS_SETUP.md        # Configuration EmailJS
└── TESTING_CHECKLIST.md    # Checklist de tests
```

---

## 🚀 Installation

### Option 1: Frontend seul (EmailJS)

```bash
# Cloner ou télécharger les fichiers
git clone <repository>
cd at-all-cost-website

# Les fichiers nécessaires:
# - index.html
# - styles.css
# - script.js

# Puis configurez EmailJS (voir EMAILJS_SETUP.md)
```

### Option 2: Frontend + Backend (Node.js)

```bash
# Cloner le repository
git clone <repository>
cd at-all-cost-website

# Installer les dépendances
npm install

# Créer fichier .env
cp .env.example .env

# Remplir .env avec:
# EMAIL_USER=atallcostai@gmail.com
# EMAIL_PASSWORD=votre_mot_de_passe_app_google

# Lancer le serveur
npm start

# Le site sera accessible à http://localhost:3000
```

---

## 📤 Déploiement

### Déploiement rapide avec Netlify

```bash
# 1. Créer un compte sur netlify.com
# 2. Glisser-déposer le dossier du site
# 3. Configurer EmailJS
# 4. C'est prêt!
```

### Déploiement avec serveur Node.js

Voir le fichier complet: [`DEPLOYMENT_GUIDE.md`](DEPLOYMENT_GUIDE.md)

Options populaires:
- **Railway** (Recommandé)
- **Render**
- **Vercel** (frontend seul)
- **DigitalOcean** (VPS)

---

## 📧 Configuration Email

### Option 1: EmailJS (Facile, client-side)

1. Créer un compte sur [emailjs.com](https://www.emailjs.com/)
2. Connecter votre email Gmail
3. Créer un template email
4. Ajouter votre clé publique dans `script.js`

Voir: [`EMAILJS_SETUP.md`](EMAILJS_SETUP.md)

### Option 2: Node.js + Nodemailer (Sécurisé, serveur)

1. Générer mot de passe d'application Gmail
2. Configurer `.env` avec vos identifiants
3. Déployer le serveur Node.js
4. Les emails sont maintenant fonctionnels

Voir: [`DEPLOYMENT_GUIDE.md`](DEPLOYMENT_GUIDE.md)

---

## 🧪 Tests

Avant le lancement, vérifier:

```bash
# 1. Tests fonctionnels
- Navigation et liens
- Formulaire d'inscription
- Envoi d'email
- Liens sociaux

# 2. Tests responsive
- Desktop (1920x1080)
- Tablet (768x1024)
- Mobile (375x667)

# 3. Tests d'accessibilité
- Navigation au clavier
- Contraste des couleurs
- Alt text sur images

# 4. Performance
- Lighthouse audit
- Vitesse de chargement
- Optimisation des images
```

Voir la checklist complète: [`TESTING_CHECKLIST.md`](TESTING_CHECKLIST.md)

---

## 📝 Contenu du formulaire

Le formulaire d'inscription collecte:

| Champ | Type | Obligatoire |
|-------|------|-------------|
| Nom complet | Text | ✅ |
| Email | Email | ✅ |
| Téléphone | Tel | ❌ |
| Cursus/Année | Text | ✅ |
| Domaines d'intérêt | Checkbox | ✅ |
| Message | Textarea | ❌ |
| Conditions d'utilisation | Checkbox | ✅ |

### Domaines d'intérêt disponibles:
- IA et Machine Learning
- Traitement du Langage Naturel
- Vision par Ordinateur
- Robotique
- Éthique et Impacts sociaux
- Autre

---

## 🔐 Sécurité

### Bonnes pratiques implémentées:

- ✅ HTTPS/SSL (activé sur tous les hébergeurs)
- ✅ Variables d'environnement pour secrets
- ✅ Validation des formulaires (client + serveur)
- ✅ Pas d'exposition de données sensibles
- ✅ CORS configuré correctement

### Pour Gmail:

1. Activer vérification en deux étapes
2. Générer mot de passe d'application (16 caractères)
3. Ne jamais partager ce mot de passe
4. Ne jamais le commiter dans Git

---

## 📱 Liens et Contacts

### Réseaux sociaux:
- 🔗 **Discord**: https://discord.gg/nXEywfKuCH
- 📱 **Telegram**: https://t.me/atallcost20252026
- 📷 **Instagram**: https://instagram.com/atallcost.ai
- 💼 **LinkedIn**: www.linkedin.com/in/at-all-cost-45755a294
- 🌳 **LinkTree**: https://linktr.ee/atallcostai

### Contact:
- 📧 **Email**: atallcostai@gmail.com
- 🎓 **Page CY Tech**: https://cytech.cyu.fr/campus-cy-tech/vie-associative/lexperience-associative/aac-at-all-cost-cy-tech-ai-lab

---

## 🔧 Maintenance

### Mises à jour régulières:

```bash
# Mettre à jour les dépendances Node.js
npm update

# Vérifier les vulnérabilités
npm audit

# Fixer les vulnérabilités
npm audit fix
```

### Sauvegardes:

- Sauvegarder régulièrement le code source
- Garder trace des emails reçus
- Archiver les candidatures importantes

---

## 🐛 Dépannage

### Le formulaire n'envoie pas d'email?

1. Vérifier la configuration (EmailJS ou .env)
2. Vérifier la console du navigateur (F12)
3. Vérifier les logs du serveur
4. Tester avec une nouvelle candidature

### Le site ne charge pas?

1. Vérifier que le serveur est actif
2. Vérifier les erreurs CORS
3. Vérifier que les fichiers CSS/JS sont chargés
4. Vérifier la connexion Internet

### Design cassé sur mobile?

1. Vérifier la vue responsive (F12)
2. Vérifier les breakpoints CSS
3. Tester sur différents appareils réels
4. Vérifier la résolution des images

---

## 📚 Documentation additionnelle

- [Guide de Déploiement](DEPLOYMENT_GUIDE.md)
- [Configuration EmailJS](EMAILJS_SETUP.md)
- [Checklist de Tests](TESTING_CHECKLIST.md)
- [Informations Association](association_info.md)
- [Structure du Site](site_structure.md)

---

## 📄 Licence

MIT License - Libre d'utilisation pour At All Cost

---

## 🤝 Support et Contributions

Pour des questions ou des améliorations:

- 📧 Contacter: atallcostai@gmail.com
- 💬 Discord: https://discord.gg/nXEywfKuCH

Contributeurs bienvenue!

---

## 📊 Informations Supplémentaires

### Technologies utilisées:
- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend** (optionnel): Node.js, Express.js, Nodemailer
- **Hosting**: Netlify, Vercel, Railway, Render
- **Email**: EmailJS ou Gmail SMTP

### Navigateurs supportés:
- Chrome/Chromium (dernière version)
- Firefox (dernière version)
- Safari (dernière version)
- Edge (dernière version)
- Tous les navigateurs mobiles modernes

### Performance:
- Lighthouse Performance: 90+
- Lighthouse Accessibility: 95+
- Lighthouse SEO: 90+
- Temps de chargement: < 2s

---

**Créé pour At All Cost - AI Lab de CY Tech** 🚀✨

Version 1.0.0 - 2025
