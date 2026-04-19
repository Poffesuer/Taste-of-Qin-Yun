(function () {
    var menu = document.querySelector('.menu');
    if (!menu) return;

    var panels = menu.querySelectorAll('.menu-category');
    var links = document.querySelectorAll('.sidebar-left a[href^="#"]');

    function syncFromHash() {
        var raw = location.hash.slice(1);
        var showAll = raw === 'all-items';
        var id = showAll
            ? 'all-items'
            : (raw && document.getElementById(raw) ? raw : 'traditional-liangpi');

        panels.forEach(function (panel) {
            panel.hidden = showAll ? false : panel.id !== id;
        });

        links.forEach(function (a) {
            var href = a.getAttribute('href');
            var match = showAll ? href === '#all-items' : href === '#' + id;
            a.classList.toggle('is-active', match);
            if (match) a.setAttribute('aria-current', 'true');
            else a.removeAttribute('aria-current');
        });
    }

    window.addEventListener('hashchange', syncFromHash);
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', syncFromHash);
    } else {
        syncFromHash();
    }
})();