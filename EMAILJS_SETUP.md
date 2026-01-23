# Configuration EmailJS - Système d'Email Client-Side

Pour une solution plus simple sans backend Node.js, vous pouvez utiliser **EmailJS** qui fonctionne entièrement côté client.

## Installation et Configuration

### 1. Créer un compte EmailJS
- Rendez-vous sur [EmailJS](https://www.emailjs.com/)
- Créez un compte gratuit
- Vérifiez votre adresse email

### 2. Connecter votre service d'email
- Dans le tableau de bord EmailJS, allez à "Email Services"
- Cliquez sur "Add Service"
- Sélectionnez "Gmail" (ou votre fournisseur d'email)
- Connectez votre compte `atallcostai@gmail.com`
- Notez votre **Service ID** (ex: `service_xxxxxx`)

### 3. Créer un template d'email
- Allez à "Email Templates"
- Créez un nouveau template
- Exemple de configuration:

```
Template Name: at_all_cost_registration
Subject: Nouvelle candidature - {{from_name}}

Email body:
Nouvelle Candidature - At All Cost

Nom: {{from_name}}
Email: {{from_email}}
Téléphone: {{telephone}}
Cursus: {{cursus}}
Domaines d'Intérêt: {{interets}}

Message:
{{message}}

---
Envoyé depuis le formulaire du site At All Cost
```

Notez votre **Template ID** (ex: `template_xxxxxx`)

### 4. Obtenir votre clé publique
- Dans les paramètres du compte ("Account")
- Copiez votre **Public Key**

### 5. Intégrer EmailJS dans le site

Modifiez le fichier `index.html` et ajoutez dans la section `<head>`:

```html
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/index.min.js"></script>
<script type="text/javascript">
  (function(){
    emailjs.init("YOUR_PUBLIC_KEY"); // Remplacer par votre clé
  })();
</script>
```

### 6. Décommenter le code EmailJS

Dans `script.js`, décommentez et modifiez la fonction `sendViaEmailJS`:

```javascript
async function sendViaEmailJS(formData) {
    if (typeof emailjs !== 'undefined') {
        try {
            emailjs.init("YOUR_PUBLIC_KEY");
            
            const templateParams = {
                to_email: 'atallcostai@gmail.com',
                from_email: formData.email,
                from_name: formData.nom,
                reply_to: formData.email,
                subject: `Nouvelle candidature - ${formData.nom}`,
                telephone: formData.telephone || 'Non fourni',
                cursus: formData.cursus,
                interets: formData.interets,
                message: formData.message || 'Aucun message'
            };
            
            await emailjs.send("SERVICE_ID", "TEMPLATE_ID", templateParams);
            return { ok: true };
        } catch (error) {
            console.error('Erreur EmailJS:', error);
            throw error;
        }
    } else {
        throw new Error('Service d\'email non configuré');
    }
}
```

Remplacer:
- `YOUR_PUBLIC_KEY` par votre clé publique
- `SERVICE_ID` par votre Service ID
- `TEMPLATE_ID` par votre Template ID

## Avantages EmailJS
- ✅ Pas de backend nécessaire
- ✅ Gratuit jusqu'à 200 emails/mois
- ✅ Simple à mettre en place
- ✅ Fonctionne directement dans le navigateur

## Avantages du serveur Node.js
- ✅ Plus sécurisé (pas d'exposition de clés côté client)
- ✅ Illimité (selon votre infrastructure)
- ✅ Plus de contrôle
- ✅ Peut intégrer une base de données

## Choix recommandé
- **Pour commencer**: EmailJS (rapide et simple)
- **Pour la production**: Serveur Node.js (plus sécurisé)
