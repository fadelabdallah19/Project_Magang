const initPenggunaFilter = () => {
    const search = document.getElementById('pengguna-search');
    const role = document.getElementById('pengguna-role');
    const rows = document.querySelectorAll('[data-pengguna-row]');
    const emptyRow = document.getElementById('pengguna-filter-empty');

    if (!search || !role) {
        return;
    }

    const filterRows = () => {
        const keyword = search.value.toLowerCase().trim();
        const selectedRole = role.value;
        let visible = 0;

        rows.forEach((row) => {
            const cocokNama = row.dataset.nama.includes(keyword);
            const cocokUsername = row.dataset.username.includes(keyword);
            const cocokRole = selectedRole === 'Semua Role' || row.dataset.role === selectedRole;
            const tampil = (cocokNama || cocokUsername) && cocokRole;

            row.classList.toggle('hidden', !tampil);

            if (tampil) {
                visible++;
            }
        });

        if (emptyRow) {
            emptyRow.classList.toggle('hidden', visible > 0);
        }
    };

    search.addEventListener('input', filterRows);
    role.addEventListener('change', filterRows);
};

const bukaModalPengguna = (modal) => {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.classList.add('overflow-hidden');
};

const tutupModalPengguna = (modal) => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.classList.remove('overflow-hidden');
};

const modalTambahPengguna = document.getElementById('modal-pengguna-tambah');
const modalEditPengguna = document.getElementById('modal-pengguna-edit');
const formEditPengguna = document.getElementById('form-pengguna-edit');

if (modalTambahPengguna) {
    document.querySelectorAll('[data-pengguna-tambah]').forEach((tombol) => {
        tombol.addEventListener('click', () => bukaModalPengguna(modalTambahPengguna));
    });
}

if (modalEditPengguna && formEditPengguna) {
    document.querySelectorAll('[data-pengguna-edit]').forEach((tombol) => {
        tombol.addEventListener('click', () => {
            const data = tombol.dataset;

            formEditPengguna.setAttribute(
                'action',
                formEditPengguna.dataset.action.replace('__ID__', data.id)
            );

            formEditPengguna.elements.name.value = data.nama;
            formEditPengguna.elements.username.value = data.username;
            formEditPengguna.elements.email.value = data.email;
            formEditPengguna.elements.role.value = data.role;
            formEditPengguna.elements.status.value = data.status;
            formEditPengguna.elements.password.value = '';

            bukaModalPengguna(modalEditPengguna);
        });
    });
}

document.querySelectorAll('[data-pengguna-modal-close]').forEach((tombol) => {
    tombol.addEventListener('click', () => {
        const modal = tombol.closest('[data-pengguna-modal]');

        if (modal) {
            tutupModalPengguna(modal);
        }
    });
});

document.querySelectorAll('[data-pengguna-modal]').forEach((modal) => {
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            tutupModalPengguna(modal);
        }
    });
});

document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') {
        return;
    }

    document.querySelectorAll('[data-pengguna-modal]').forEach((modal) => {
        if (!modal.classList.contains('hidden')) {
            tutupModalPengguna(modal);
        }
    });
});

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initPenggunaFilter);
} else {
    initPenggunaFilter();
}