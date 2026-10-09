(() => {
  const menu = document.querySelector('[data-mobile-menu]');
  const openButton = document.querySelector('[data-menu-open]');
  const closeButton = document.querySelector('[data-menu-close]');

  if (menu && openButton) {
    const setOpen = (open) => {
      menu.classList.toggle('is-open', open);
      menu.setAttribute('aria-hidden', String(!open));
      openButton.setAttribute('aria-expanded', String(open));
      document.body.classList.toggle('menu-is-open', open);
    };
    openButton.addEventListener('click', () => setOpen(true));
    closeButton?.addEventListener('click', () => setOpen(false));
    menu.addEventListener('click', (event) => {
      if (event.target === menu) setOpen(false);
    });
    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') setOpen(false);
    });
  }

  document.querySelectorAll('[data-current-year]').forEach((element) => {
    element.textContent = new Date().getFullYear();
  });
})();
