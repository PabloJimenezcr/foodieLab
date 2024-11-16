let showPassIcons = document.querySelectorAll('.showPassword');

showPassIcons.forEach(function(icon) {
    icon.addEventListener('click', function() {
        let passwordInput = icon.previousElementSibling;

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('ri-eye-line');
            icon.classList.add('ri-eye-off-line');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('ri-eye-off-line');
            icon.classList.add('ri-eye-line');
        }
    });
});