document.addEventListener('DOMContentLoaded', function () {
    const accountButton = document.getElementById('mlAccountDropdown');
    const accountMenu = document.querySelector('.ml-account-dropdown');
    const accountWrapper = document.querySelector('.ml-account-desktop');

    if (!accountButton || !accountMenu || !accountWrapper) {
        return;
    }

    accountButton.addEventListener('click', function (event) {
        event.preventDefault();
        event.stopPropagation();

        const isOpen = accountMenu.classList.contains('show');

        accountMenu.classList.toggle('show', !isOpen);
        accountButton.classList.toggle('show', !isOpen);
        accountButton.setAttribute('aria-expanded', String(!isOpen));
    });

    accountMenu.addEventListener('click', function (event) {
        event.stopPropagation();
    });

    document.addEventListener('click', function (event) {
        if (!accountWrapper.contains(event.target)) {
            accountMenu.classList.remove('show');
            accountButton.classList.remove('show');
            accountButton.setAttribute('aria-expanded', 'false');
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            accountMenu.classList.remove('show');
            accountButton.classList.remove('show');
            accountButton.setAttribute('aria-expanded', 'false');
        }
    });
});