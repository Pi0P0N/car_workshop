document.addEventListener('DOMContentLoaded', function () {
    const html = document.documentElement;
    const toggle = document.getElementById('toggle-dark-mode');

    let currentTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-bs-theme', currentTheme);

    if (toggle) {
        toggle.checked = currentTheme === 'dark';

        toggle.addEventListener('change', function () {
            const newTheme = this.checked ? 'dark' : 'light';
            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    }

    let requiredFields = document.querySelectorAll('input[required], select[required]');
    requiredFields.forEach(function(field) {
        let label = document.querySelector(`label[for="${field.id}"]`);
        if (label) {
            label.innerHTML += ' <span class="text-danger">*</span>';
        }
    });
});