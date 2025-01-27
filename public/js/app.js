document.addEventListener('DOMContentLoaded', function () {
    const html = document.documentElement;
    const toggle = document.getElementById('toggle-dark-mode');

    if (toggle) {
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-bs-theme', savedTheme);
        toggle.checked = savedTheme === 'dark';

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