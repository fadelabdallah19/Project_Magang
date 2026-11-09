const badgeBaseClass = 'inline-flex min-h-[23px] items-center rounded-full px-[10px] py-[3px] text-[9px] font-semibold whitespace-nowrap';
const badgeNeutralClass = `${badgeBaseClass} bg-[#F4F6FA] text-[#6D7B90]`;
const badgeMinusClass = `${badgeBaseClass} bg-[#FFF0F0] text-[#D94E4E]`;
const badgePlusClass = `${badgeBaseClass} bg-[#EDF7F1] text-[#257A59]`;

document.querySelectorAll('[data-stok-fisik]').forEach((input) => {
    input.addEventListener('input', () => {
        const target = document.getElementById(`selisih-${input.dataset.row}`);

        if (!target) {
            return;
        }

        if (input.value === '') {
            target.textContent = '-';
            target.className = badgeNeutralClass;
            return;
        }

        const sistem = Number(input.dataset.sistem);
        const fisik = Number(input.value);
        const selisih = fisik - sistem;

        target.textContent = selisih > 0 ? `+${selisih}` : `${selisih}`;
        target.className = selisih < 0
            ? badgeMinusClass
            : selisih > 0
                ? badgePlusClass
                : badgeNeutralClass;
    });
});

const search = document.getElementById('opname-search');
const rows = document.querySelectorAll('[data-opname-row]');
const emptyRow = document.getElementById('opname-filter-empty');

if (search) {
    search.addEventListener('input', () => {
        const keyword = search.value.toLowerCase().trim();
        let visible = 0;

        rows.forEach((row) => {
            const matches = row.dataset.cari.includes(keyword);
            row.classList.toggle('hidden', !matches);

            if (matches) {
                visible++;
            }
        });

        if (emptyRow) {
            emptyRow.classList.toggle('hidden', visible > 0);
        }
    });
}