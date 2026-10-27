const bukaModal = (modal) => {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.classList.add('overflow-hidden');
};

const tutupModal = (modal) => {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.classList.remove('overflow-hidden');
};

// Modal Tambah
const modalTambah = document.getElementById('modal-tambah');

if (modalTambah) {
    document.querySelectorAll('[data-modal-open]').forEach((tombol) => {
        tombol.addEventListener('click', () => bukaModal(modalTambah));
    });

    modalTambah.addEventListener('click', (event) => {
        if (event.target === modalTambah) {
            tutupModal(modalTambah);
        }
    });

    if (modalTambah.dataset.openOnError === 'true') {
        bukaModal(modalTambah);
    }
}

// Modal Edit
const modalEdit = document.getElementById('modal-edit');
const formEdit = document.getElementById('form-edit');

if (modalEdit && formEdit) {
    const isiFormEdit = (data) => {
        formEdit.setAttribute(
            'action',
            formEdit.dataset.action.replace('__KODE__', encodeURIComponent(data.kode))
        );

        formEdit.elements.kode.value = data.kode;
        formEdit.elements.kode_awal.value = data.kode;
        formEdit.elements.nama.value = data.nama;
        formEdit.elements.kategori.value = data.kategori;
        formEdit.elements.stok.value = data.stok;
        formEdit.elements.satuan.value = data.satuan;

        document.getElementById('edit-kode').value = data.kode;
    };

    document.querySelectorAll('[data-modal-edit]').forEach((tombol) => {
        tombol.addEventListener('click', () => {
            isiFormEdit(tombol.dataset);
            bukaModal(modalEdit);
        });
    });

    modalEdit.addEventListener('click', (event) => {
        if (event.target === modalEdit) {
            tutupModal(modalEdit);
        }
    });

    if (modalEdit.dataset.openOnError === 'true') {
        bukaModal(modalEdit);
    }
}

// Tombol tutup & Escape buat semua
document.querySelectorAll('[data-modal-close]').forEach((tombol) => {
    tombol.addEventListener('click', () => {
        const modal = tombol.closest('[data-modal]');

        if (modal) {
            tutupModal(modal);
        }
    });
});

document.addEventListener('keydown', (event) => {
    if (event.key !== 'Escape') {
        return;
    }

    document.querySelectorAll('[data-modal]').forEach((modal) => {
        if (!modal.classList.contains('hidden')) {
            tutupModal(modal);
        }
    });
});