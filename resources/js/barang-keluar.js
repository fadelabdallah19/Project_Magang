const bahanSelect = document.getElementById('keluar-bahan');
const satuanInput = document.getElementById('keluar-satuan');

if (bahanSelect && satuanInput) {
    const syncSatuan = () => {
        const selected = bahanSelect.option[bahanSelect.selectedIndex];
        satuanInput.value = selected?.dataset.satuan ?? '';
    };

    bahanSelect.addEventListener('change', syncSatuan);

    if (!satuanInput.value) {
        syncSatuan();
    }
}

const search = document.getElementById('keluar-search');
const rows = document.querySelectorAll('[data-keluar-row]');
const emptyRow = document.getElementById('keluar-filter-empty');

if (search) {
    search.addEventListener('input', () => {
        const keyword = search.value.toLowerCase().trim();
        let visible = 0;

        rows.forEach((row) => {
            const matches = row.dataset.cari.includes(keyword);
            row.classList.toggle('hiddem', !matches);

            if (matches) {
                visible++
            }
        });

        if (emptyRow) {
            emptyRow.classList.toggle('hidden', visible > 0);
        }
    });
}