(function () {

    const STORAGE_KEY = 'asnet-theme';

    function applyTheme(theme) {
        if (theme === 'dark') {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
        updateIcons(theme);
    }

    function updateIcons(theme) {
        document.querySelectorAll('.theme-toggle-icon').forEach(function (icon) {
            icon.className = 'theme-toggle-icon bi ' +
                (theme === 'dark' ? 'bi-sun-fill' : 'bi-moon-stars-fill');
        });
    }

    function toggleTheme() {
        const isDark = document.body.classList.contains('dark-mode');
        const newTheme = isDark ? 'light' : 'dark';
        localStorage.setItem(STORAGE_KEY, newTheme);
        applyTheme(newTheme);
    }

    // Apply saved theme as early as possible
    const saved = localStorage.getItem(STORAGE_KEY) || 'light';
    applyTheme(saved);

    document.addEventListener('DOMContentLoaded', function () {
        updateIcons(localStorage.getItem(STORAGE_KEY) || 'light');

        document.querySelectorAll('.theme-toggle, .theme-toggle-user').forEach(function (btn) {
            btn.addEventListener('click', toggleTheme);
        });
    });

})();