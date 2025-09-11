document.querySelectorAll('.btn-toggle-password').forEach(btn => {
  btn.addEventListener('click', () => {
    const wrapper = btn.closest('.relative');
    if (!wrapper) return;
    const input = wrapper.querySelector('input[type="password"], input[type="text"]');
    if (!input) return;

    const icon = btn.querySelector('i');
    const wasPassword = input.type === 'password';

    input.type = wasPassword ? 'text' : 'password';

    if (icon) {
      if (wasPassword) icon.classList.replace('bi-eye', 'bi-eye-slash');
      else icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
  });
});
