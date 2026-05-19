const toggle = document.querySelector('[data-nav-toggle]');
const panel = document.querySelector('[data-nav-panel]');

if (toggle && panel) {
  toggle.addEventListener('click', () => {
    panel.classList.toggle('open');
  });
}

const reveals = document.querySelectorAll('.reveal');
const revealOnScroll = () => {
  reveals.forEach((element) => {
    const top = element.getBoundingClientRect().top;
    if (top < window.innerHeight - 120) {
      element.classList.add('active');
    }
  });
};

window.addEventListener('scroll', revealOnScroll);
revealOnScroll();

const codeButton = document.querySelector('[data-ai-code-fetch]');
const codeResult = document.querySelector('[data-ai-code-result]');

if (codeButton && codeResult) {
  codeButton.addEventListener('click', async () => {
    codeButton.disabled = true;
    codeButton.textContent = 'Chargement...';

    try {
      const response = await fetch(codeButton.dataset.endpoint, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-Token': window.AT_ALL_COST.csrfToken,
        },
        body: JSON.stringify({}),
      });

      const payload = await response.json();
      if (!response.ok) {
        throw new Error(payload.error || 'Erreur API');
      }

      codeResult.innerHTML = `
        <div class="code-result">
          <div class="code-token"><strong>Code IA</strong><br>${payload.ai_code}</div>
          <div class="code-token"><strong>Code validation</strong><br>${payload.validation_code}</div>
          <div class="muted">Source: ${payload.source} · ${new Date(payload.requested_at).toLocaleString('fr-FR')}</div>
        </div>
      `;
    } catch (error) {
      codeResult.innerHTML = `<p class="code-placeholder">${error.message}</p>`;
    } finally {
      codeButton.disabled = false;
      codeButton.textContent = 'Recuperer les codes';
    }
  });
}
