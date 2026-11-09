const initBahanFilter = () => {
    const search = document.getElementById('bahan-search');
    const kategori = document.getElementById('bahan-kategori');
    const rows = document.querySelectorAll('[data-bahan-row]');
    const emptyRow = document.getElementById('bahan-filter-empty');

    if (!search || !kategori) {
        return;
    }

    const filterRows = () => {
        const keyword = search.value.toLowerCase().trim();
        const selectedKategori = kategori.value;
        let visible = 0;

        rows.forEach((row) => {
            const cocokKode = row.dataset.kode.includes(keyword);
            const cocokNama = row.dataset.nama.includes(keyword);
            const cocokKategori = selectedKategori === 'Semua Kategori' || row.dataset.kategori === selectedKategori;
            const tampil = (cocokKode || cocokNama) && cocokKategori;

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
    kategori.addEventListener('change', filterRows);
};

if (document.readyState === 'loading') {
    document.addEventListener('DIMContentLoaded', initBahanFilter);
} else {
    initBahanFilter();
}