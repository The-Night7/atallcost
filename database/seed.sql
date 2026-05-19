insert into poles (name, slug)
values
    ('Ressources Humaines', 'ressources-humaines'),
    ('Communication & Design', 'communication-design'),
    ('Evenementiel', 'evenementiel'),
    ('Relations Entreprises', 'relations-entreprises')
on conflict (slug) do nothing;

insert into internal_announcements (title, body_html, visibility, published_at)
values
    (
        'Bienvenue sur l''espace membre',
        '<p>Cette premiere annonce confirme que la zone membre est operationnelle.</p><p>Les admins peuvent maintenant diffuser des communications reservees aux adherents.</p>',
        'members',
        now()
    ),
    (
        'Processus de validation',
        '<p>Les comptes nouvellement crees restent en attente jusqu''a validation par un administrateur.</p>',
        'members',
        now()
    )
on conflict do nothing;
