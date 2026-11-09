const bahanSelect = document.getElementById('bahan')
const satuanInput = document.getElementById('satuan')

if (bahanSelect && satuanInput) {
    const syncSatuan = () => {
        const selected = bahanSelect.options[bahanSelect.selectedIndex]
        satuanInput.value = selected?.dataset.satuan ?? ''
    }

    bahanSelect.addEventListener('change', syncSatuan)

    if (!satuanInput.value) {
        syncSatuan()
    }
}

const searchInput = document.getElementById('masuk-search')
const rows = document.querySelectorAll('[data-masuk-row]')
const emptyRow = document.getElementById('masuk-filter-empty')

if (searchInput) {
    searchInput.addEventListener('input', () => {
        const keyword = searchInput.value.toLowerCase().trim()
        let visible = 0

        rows.forEach((row) => {
            const matches = row.dataset.cari.includes(keyword)
            row.classList.toggle('hidden', !matches)

            if (matches) {
                visible += 1
            }
        })

        if (emptyRow) {
            emptyRow.classList.toggle('hidden', visible > 0)
        }
    })
}