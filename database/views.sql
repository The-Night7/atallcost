create or replace view v_dashboard_summary as
select
    count(*) filter (where status in ('member', 'staff', 'admin')) as total_members,
    (select count(*) from ai_code_requests) as total_requests,
    (select count(*) from poles where is_active = true) as total_poles
from profiles;

create or replace view v_members_by_major as
select major, count(*) as members
from profiles
where status in ('member', 'staff', 'admin')
group by major;

create or replace view v_members_by_study_year as
select study_year, count(*) as members
from profiles
where status in ('member', 'staff', 'admin')
group by study_year;

create or replace view v_pole_population_rates as
select
    p.id,
    p.name,
    count(pr.id) as members_count,
    round(
        (count(pr.id)::numeric / nullif((select count(*) from profiles where status in ('member', 'staff', 'admin')), 0)) * 100,
        2
    ) as population_rate
from poles p
left join profile_poles pp on pp.pole_id = p.id
left join profiles pr on pr.id = pp.profile_id and pr.status in ('member', 'staff', 'admin')
where p.is_active = true
group by p.id, p.name;

create or replace view v_ai_code_requests_per_user as
select
    pr.id as profile_id,
    pr.first_name,
    pr.last_name,
    pr.email,
    count(r.id) as request_count
from profiles pr
left join ai_code_requests r on r.profile_id = pr.id
group by pr.id, pr.first_name, pr.last_name, pr.email;

create or replace view v_ai_code_requests_admin as
select
    r.*,
    pr.first_name,
    pr.last_name,
    pr.email,
    count(*) over (partition by r.profile_id) as request_count
from ai_code_requests r
left join profiles pr on pr.id = r.profile_id;
