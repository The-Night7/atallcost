document.querySelectorAll('.chart-card').forEach((card) => {
  const target = card.querySelector('[data-chart-target]');
  if (!target) {
    return;
  }

  const rows = JSON.parse(card.dataset.chart || '[]');
  const values = rows.map((row) => Number(row.members ?? row.members_count ?? row.population_rate ?? 0));
  const max = Math.max(...values, 1);

  target.innerHTML = rows.map((row) => {
    const label = row.major ?? row.study_year ?? row.name ?? 'NC';
    const value = Number(row.members ?? row.members_count ?? row.population_rate ?? 0);
    const percent = Math.max(6, Math.round((value / max) * 100));
    return `
      <div class="chart-row">
        <div class="chart-label"><span>${label}</span><strong>${value}</strong></div>
        <div class="chart-track"><div class="chart-fill" style="width:${percent}%"></div></div>
      </div>
    `;
  }).join('');
});
