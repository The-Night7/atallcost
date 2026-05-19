# At All Cost PHP sur Vercel

Application PHP pour l'association At All Cost avec:
- site public reprenant l'identite visuelle existante
- authentification email/mot de passe + Google via Supabase
- espace membre pour annonces internes et recuperation de codes IA
- espace admin pour utilisateurs, poles, annonces, dashboard et exports CSV

## Arborescence

- `api/index.php`: front controller Vercel/PHP
- `app/`: logique HTTP, services, repositories, middleware et vues
- `public/assets/`: CSS et JavaScript front
- `database/schema.sql`: tables et fonction RPC
- `database/views.sql`: vues analytiques exposees via Supabase REST
- `database/seed.sql`: donnees initiales
- `vercel.json`: runtime `vercel-php` + routage

## Variables d'environnement

Copier `.env.example` vers `.env` puis renseigner:

- `APP_URL`
- `SUPABASE_URL`
- `SUPABASE_ANON_KEY`
- `SUPABASE_SERVICE_ROLE_KEY`
- `GOOGLE_REDIRECT_URI`
- `AI_CODE_PROVIDER_MODE=stub|external`
- `AI_CODE_API_URL`
- `AI_CODE_API_KEY`

## Mise en place Supabase

1. Creer un projet Supabase.
2. Executer `database/schema.sql`.
3. Executer `database/views.sql`.
4. Executer `database/seed.sql`.
5. Verifier que PostgREST expose les tables, vues et la fonction `replace_profile_poles`.
6. Configurer Google OAuth dans Supabase Auth avec le callback `GOOGLE_REDIRECT_URI`.

## Lancement local

```bash
composer install
composer serve
```

Le script de dev demarre `php -S` avec `api/index.php` comme point d'entree.

## Deploiement Vercel

1. Importer le depot dans Vercel.
2. Renseigner les variables d'environnement du `.env.example`.
3. Laisser `vercel.json` router toutes les pages dynamiques vers `api/index.php`.
4. Verifier que le runtime communautaire `vercel-php` est bien utilise.

## Fonctionnalites

### Public
- `/` page vitrine
- `/connexion`
- `/inscription`
- `/attente-validation`

### Membre
- `/annonces`
- `/codes-ia`

### Admin
- `/admin`
- `/admin/utilisateurs`
- `/admin/poles`
- `/admin/annonces`
- `/admin/requetes-codes`
- `/admin/exports`

## Notes d'implementation

- Les comptes sont crees avec le statut `pending`.
- Les pages membres sont reservees aux statuts `member`, `staff` et `admin`.
- Les admins voient la PII uniquement dans la gestion utilisateurs.
- Chaque requete de recuperation de codes est loggee dans `ai_code_requests`.
- Les exports CSV sont separes entre statistiques, membres et logs.
- Le provider de codes IA utilise soit un stub, soit un endpoint externe normalise.

## Limites connues

- Le projet ne contient pas de dependances PHP externes: tout est implemente en natif pour rester portable.
- Les integrations Supabase et Google OAuth necessitent des variables d'environnement valides pour etre executees.
- Aucun test automatise n'est present dans ce commit; verifier la syntaxe PHP et l'integration Supabase avant la mise en production.
