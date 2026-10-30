// Hitung selisih stok opname secara otomatis
const inputStokFisik = document.querySelectorAll('[data-stok-fisik]');

inputStokFisik.forEach((input) => {
    input.addEventListener('input', () => {
        const target = document.getElementById(`selisih-${input.dataset.row}`);

        if (!target) {
            return;
        }

        if (input.value === '') {
            target.textContent = '-';
            target.className = 'font-bold text-[#959595]';
            return;
        }

        const sistem = Number(input.dataset.sistem);
        const fisik = Number(input.value);
        const selisih = fisik - sistem;

        target.textContent = selisih > 0 ? `+${selisih}` : `${selisih}`;
        target.className = 'font-bold ' + (
            selisih < 0 ? 'text-[#DC2626]'
            : selisih > 0 ? 'text-[#16A34A]'
            : 'text-[#959595]'
        );
    });
});
