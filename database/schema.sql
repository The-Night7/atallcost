create extension if not exists pgcrypto;

create table if not exists profiles (
    id uuid primary key default gen_random_uuid(),
    auth_user_id uuid unique not null,
    first_name text not null,
    last_name text not null,
    study_year text not null,
    birth_date date,
    email text unique not null,
    phone text not null,
    major text not null,
    status text not null check (status in ('pending', 'member', 'staff', 'admin', 'archived')),
    is_google_account boolean not null default false,
    created_at timestamptz not null default now(),
    validated_at timestamptz,
    archived_at timestamptz
);

create table if not exists poles (
    id uuid primary key default gen_random_uuid(),
    name text not null unique,
    slug text not null unique,
    is_active boolean not null default true,
    created_at timestamptz not null default now(),
    archived_at timestamptz
);

create table if not exists profile_poles (
    profile_id uuid not null references profiles(id) on delete cascade,
    pole_id uuid not null references poles(id) on delete cascade,
    assigned_at timestamptz not null default now(),
    primary key (profile_id, pole_id)
);

create table if not exists internal_announcements (
    id uuid primary key default gen_random_uuid(),
    title text not null,
    body_html text not null,
    visibility text not null default 'members',
    published_at timestamptz not null default now(),
    archived_at timestamptz,
    created_by uuid references profiles(id) on delete set null
);

create table if not exists ai_code_requests (
    id uuid primary key default gen_random_uuid(),
    profile_id uuid references profiles(id) on delete set null,
    provider text not null,
    request_status text not null,
    ai_code_masked text,
    validation_code_masked text,
    response_excerpt text,
    http_status integer,
    requested_at timestamptz not null default now()
);

create table if not exists admin_audit_logs (
    id uuid primary key default gen_random_uuid(),
    admin_profile_id uuid references profiles(id) on delete set null,
    action text not null,
    target_type text not null,
    target_id text,
    payload_json jsonb not null default '{}'::jsonb,
    created_at timestamptz not null default now()
);

create index if not exists idx_profiles_status on profiles(status);
create index if not exists idx_profiles_major on profiles(major);
create index if not exists idx_profiles_study_year on profiles(study_year);
create index if not exists idx_ai_code_requests_profile_id on ai_code_requests(profile_id);
create index if not exists idx_ai_code_requests_requested_at on ai_code_requests(requested_at desc);

create or replace function replace_profile_poles(p_profile_id uuid, p_pole_ids uuid[])
returns void
language plpgsql
security definer
as $$
begin
    delete from profile_poles where profile_id = p_profile_id;

    insert into profile_poles (profile_id, pole_id)
    select p_profile_id, unnest(p_pole_ids);
end;
$$;
