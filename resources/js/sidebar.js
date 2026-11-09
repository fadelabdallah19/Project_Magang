const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebar-overlay');
const toggle = document.querySelector('[data-sidebar-toggle]');
const closeButtons = document.querySelectorAll('[data-sidebar-close]');

const bukaSidebar = () => {
    if (!sidebar || !overlay) {
        return;
    }

    sidebar.classList.remove('-translate-x-full');
    sidebar.classList.add('translate-x-0');
    overlay.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
    toggle?.setAttribute('aria-expanded', 'true');
};

const tutupSidebar = () => {
    if (!sidebar || !overlay) {
        return;
    }

    sidebar.classList.add('-translate-x-full');
    sidebar.classList.remove('translate-x-0');
    overlay.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
    toggle?.setAttribute('aria-expanded', 'false');
};

toggle?.addEventListener('click', bukaSidebar);
overlay?.addEventListener('click', tutupSidebar);

closeButtons.forEach((tombol) => {
    tombol.addEventListener('click', tutupSidebar);
});

// tutup otomastis
sidebar?.querySelectorAll('a').forEach((link) => {
    link.addEventListener('click', tutupSidebar);
});

// esc buat nutup sidebar
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        tutupSidebar();
    }
});

// kalau layar diperbesar, scroll ga kekunci
window.addEventListener('resize', () => {
    if (window.innerWidth >= 1024) {
        tutupSidebar();
    }
});