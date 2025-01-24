document.addEventListener('DOMContentLoaded', function () {
    const html = document.documentElement;
    const toggle = document.getElementById('toggle-dark-mode');

    // Load the saved theme from localStorage
    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-bs-theme', savedTheme);
    toggle.checked = savedTheme === 'dark';

    // Add event listener to the toggle switch
    toggle.addEventListener('change', function () {
        const newTheme = this.checked ? 'dark' : 'light';
        html.setAttribute('data-bs-theme', newTheme);
        localStorage.setItem('theme', newTheme);
    });
});