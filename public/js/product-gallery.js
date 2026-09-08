document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.product-gallery-card-delete-form').forEach(function (form) {
        const button = form.querySelector('.product-gallery-card-delete-btn');

        form.addEventListener('click', function (event) {
            event.stopPropagation();
        });

        if (!button) {
            return;
        }

        button.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();

            const confirmed = window.confirm(
                'Are you sure you want to permanently delete this image?'
            );

            if (confirmed) {
                form.submit();
            }
        });
    });

    document.addEventListener('click', async function (event) {
        const button = event.target.closest('.copy-image-url');

        if (!button) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        const url = button.dataset.url;
        const originalHtml = button.innerHTML;

        try {
            await navigator.clipboard.writeText(url);

            button.innerHTML = '<i class="bi bi-check2"></i> Copied';
            button.classList.add('is-copied');

            setTimeout(function () {
                button.innerHTML = originalHtml;
                button.classList.remove('is-copied');
            }, 1600);
        } catch (error) {
            window.prompt('Copy image URL:', url);
        }
    });
});
