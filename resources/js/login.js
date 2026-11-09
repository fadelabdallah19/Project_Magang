const usernameInput = document.getElementById('username');
const passwordInput = document.getElementById('password');
const togglePassword = document.querySelector('[data-toggle-password]');

// lihat atau sembunyikan password
if (passwordInput && togglePassword) {
    const iconEye = togglePassword.querySelector('[data-icon-eye]');
    const iconEyeOff = togglePassword.querySelector('[data-icon-eye-off]');

    togglePassword.addEventListener('click', () => {
        const tampil = passwordInput.type === 'password';

        passwordInput.type = tampil ? 'text' : 'password';

        iconEye?.classList.toggle('hidden', tampil);
        iconEyeOff?.classList.toggle('hidden', !tampil);

        togglePassword.setAttribute(
            'aria-label',
            tampil ? 'Sembunyikan password' : 'Tampilkan password'
        );
    });
}

// isi form dari tombol akses demo
if (usernameInput && passwordInput) {
    document.querySelectorAll('[data-demo-username]').forEach((tombol) => {
        tombol.addEventListener('click', () => {
            usernameInput.value = tombol.dataset.demoUsername;
            passwordInput.value = 'password'; // sesuaikan dengan akun demo
            passwordInput.focus()
        });
    });
}