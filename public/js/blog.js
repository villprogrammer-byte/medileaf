
document.addEventListener('DOMContentLoaded', function () {
    const cartDrawer = document.getElementById('mlCartDrawer');
    const cartOverlay = document.getElementById('mlCartOverlay');

    if (cartDrawer) {
        cartDrawer.classList.remove('active');
    }

    if (cartOverlay) {
        cartOverlay.classList.remove('active');
    }

    document.querySelectorAll('#mlCartOpen, .ml-cart-btn').forEach(function (button) {
        button.classList.remove('active');
    });
});

// ==========================blog======================================

document.addEventListener('DOMContentLoaded', function () {

    const description = document.querySelector('#description');

    if (!description) {
        return;
    }

    if (typeof ClassicEditor === 'undefined') {
        console.error('CKEditor is not loaded.');
        return;
    }

    ClassicEditor
        .create(description, {
            toolbar: [
                'undo',
                'redo',
                '|',
                'heading',
                '|',
                'bold',
                'italic',
                '|',
                'link',
                'insertImage',
                'insertTable',
                'blockQuote',
                '|',
                'bulletedList',
                'numberedList',
                '|',
                'outdent',
                'indent'
            ]
        })
        .then(editor => {
            window.blogDescriptionEditor = editor;
        })
        .catch(error => {
            console.error('CKEditor initialisation error:', error);
        });

});