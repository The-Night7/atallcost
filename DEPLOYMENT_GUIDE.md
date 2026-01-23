# Guide de Déploiement - Site At All Cost

## Option 1: Déploiement Simple (Frontend uniquement - EmailJS)

### Via Netlify (Recommandé)
1. **Créer un compte** sur [Netlify](https://www.netlify.com/)
2. **Préparer les fichiers**:
   - Créez un dossier `at-all-cost-site/`
   - Déplacez-y: `index.html`, `styles.css`, `script.js`
3. **Déployer**:
   - Glissez-déposez le dossier sur Netlify
   - OU connectez votre repository GitHub
4. **Configurer EmailJS** (voir EMAILJS_SETUP.md)
5. **Votre site est en ligne!** 🎉

### Via GitHub Pages
1. Créez un repository `atallcost.github.io`
2. Versionnez vos fichiers: `index.html`, `styles.css`, `script.js`
3. Poussez sur GitHub
4. Le site sera accessible à `https://atallcost.github.io`

### Via Vercel
1. Connectez votre repository GitHub à [Vercel](https://vercel.com/)
2. Importez et déployez en un clic
3. URL: `https://your-site.vercel.app`

---

## Option 2: Déploiement Complet (Avec serveur Node.js)

### Via Heroku (Gratuit - Note: Heroku a arrêté les plans gratuits)

### Via Railway
1. **Créer un compte** sur [Railway](https://railway.app/)
2. **Préparer le repository**:
   ```bash
   git init
   git add .
   git commit -m "Initial commit"
   git push
   ```
3. **Déployer sur Railway**:
   - Connectez votre repository GitHub
   - Railway détectera automatiquement Node.js
   - Configurez les variables d'environnement
4. **Ajouter les variables d'environnement**:
   - `EMAIL_USER`: atallcostai@gmail.com
   - `EMAIL_PASSWORD`: votre mot de passe d'application Google
   - `NODE_ENV`: production
5. **Déployez!** Railway construira et déploiera automatiquement

### Via Render
1. **Créer un compte** sur [Render](https://render.com/)
2. **Créer un nouveau Web Service**:
   - Connectez votre repository GitHub
   - Sélectionnez Node
   - Build command: `npm install`
   - Start command: `npm start`
3. **Configurez les variables d'environnement**
4. **Deploy!**

### Via AWS, DigitalOcean, ou Linode
Consultez leur documentation respective pour Node.js

---

## Configuration locale (développement)

### Installation
```bash
# Cloner ou télécharger les fichiers
cd at-all-cost-site

# Installer les dépendances
npm install

# Créer un fichier .env
cp .env.example .env

# Remplir le fichier .env avec:
# EMAIL_USER=atallcostai@gmail.com
# EMAIL_PASSWORD=votre_mot_de_passe_app_google
```

### Lancer le serveur local
```bash
# Production
npm start

# Développement (avec rechargement automatique)
npm run dev
```

Le serveur tourne sur `http://localhost:3000`

---

## Configuration Gmail (Mot de passe d'application)

1. **Activer la Vérification en deux étapes** sur le compte Gmail
2. **Générer un mot de passe d'application**:
   - Allez à [Google Account Security](https://myaccount.google.com/security)
   - Sous "Mots de passe d'application"
   - Sélectionnez "Mail" et "Windows"
   - Générez un mot de passe (16 caractères)
   - Utilisez ce mot de passe dans `EMAIL_PASSWORD`

---

## Fichiers à versionner

```
at-all-cost-site/
├── index.html
├── styles.css
├── script.js
├── email_config.js
├── package.json
├── .env.example (NON le fichier .env lui-même!)
├── .gitignore
└── README.md
```

### Contenu de .gitignore
```
node_modules/
.env
.DS_Store
*.log
dist/
```

---

## Problèmes courants

### "Email non reçu"
- Vérifiez le mot de passe d'application Gmail
- Vérifiez que l'adresse destinataire est correcte
- Vérifiez les logs du serveur pour les erreurs

### "Port déjà utilisé"
```bash
# Changer le port dans .env
PORT=3001
```

### "Erreur CORS"
- Vérifiez que CORS est activé dans express
- Les variables d'environnement sont correctement définies

---

## Monitoring et logs

Sur Railway/Render:
- Logs accessibles via le tableau de bord
- Vérifier les erreurs de déploiement
- Monitorer l'utilisation du serveur

---

## Support SSL/HTTPS

Tous les hébergeurs modernes proposent SSL gratuit:
- **Netlify**: Automatique
- **Vercel**: Automatique
- **Railway**: Automatique
- **Render**: Automatique

Le HTTPS est obligatoire pour Nodemailer avec Gmail.

---

## Domaine personnalisé

Si vous avez un domaine `atallcost.ai`:
- Netlify/Vercel: Ajoutez dans les paramètres du site
- Railway/Render: Configurez les DNS CNAME

Example pour Railway:
```
CNAME: yourdomain.com → your-railway-app.up.railway.app
```

---

## Checklist de lancement

- [ ] Domain configuré (optionnel)
- [ ] EmailJS configuré OU serveur Node.js déployé
- [ ] Adresse email `atallcostai@gmail.com` vérifiée
- [ ] Tests du formulaire effectués
- [ ] Emails de test reçus
- [ ] CSS/images chargés correctement
- [ ] Responsive design testé sur mobile
- [ ] Links sociaux testés
- [ ] SEO méta tags configurés
- [ ] Certificat SSL actif

---

## Après le lancement

- Monitorer les emails reçus
- Mettre à jour le contenu régulièrement
- Vérifier les liens cassés périodiquement
- Faire des sauvegardes régulières
- Surveiller les performances et les erreurs

Besoin d'aide? Contactez l'équipe At All Cost: atallcostai@gmail.com
