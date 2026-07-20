document.addEventListener('DOMContentLoaded', function () {
    const categoryLinks = document.querySelectorAll('.ml-shop-v2-category-scroll a');
    const searchInput = document.getElementById('mlShopSearch');
    const sortSelect = document.getElementById('mlShopSort');
    const grid = document.getElementById('mlShopGrid');
    const pagination = document.getElementById('mlShopPagination');
    const noProducts = document.getElementById('mlShopNoProducts');

    if (!grid || !pagination) return;

    const productsPerPage = 8;
    let currentCategory = 'all';
    let currentPage = 1;
    const allProducts = Array.from(grid.querySelectorAll('.ml-shop-product-item'));

    function getFilteredProducts() {
        const searchValue = searchInput ? searchInput.value.toLowerCase().trim() : '';

        const filtered = allProducts.filter(function (product) {
            const categoryMatch = currentCategory === 'all' || product.dataset.category === currentCategory;
            const nameMatch = product.dataset.name.toLowerCase().includes(searchValue);
            return categoryMatch && nameMatch;
        });

        if (!sortSelect) return filtered;

        const value = sortSelect.value;
        filtered.sort(function (a, b) {
            const nameA = a.dataset.name.toLowerCase();
            const nameB = b.dataset.name.toLowerCase();
            const priceA = Number(a.dataset.price);
            const priceB = Number(b.dataset.price);

            if (value === 'low') return priceA - priceB;
            if (value === 'high') return priceB - priceA;
            if (value === 'az') return nameA.localeCompare(nameB);
            if (value === 'latest') return Number(b.dataset.id) - Number(a.dataset.id);
            return 0;
        });

        return filtered;
    }

    function renderPagination(totalProducts) {
        const totalPages = Math.ceil(totalProducts / productsPerPage);
        pagination.innerHTML = '';
        if (totalPages <= 1) return;

        function createButton(text, page, isActive, disabled) {
            const button = document.createElement('button');
            button.innerHTML = text;
            button.disabled = disabled;
            if (isActive) button.classList.add('active');

            button.addEventListener('click', function () {
                if (disabled) return;
                currentPage = page;
                renderProducts();
                grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });

            pagination.appendChild(button);
        }

        createButton('1', 1, currentPage === 1, false);
        if (currentPage > 4) createButton('...', currentPage, false, true);

        for (let i = Math.max(2, currentPage - 1); i <= Math.min(totalPages - 1, currentPage + 1); i++) {
            createButton(i, i, currentPage === i, false);
        }

        if (currentPage < totalPages - 3) createButton('...', currentPage, false, true);
        if (totalPages > 1) createButton(totalPages, totalPages, currentPage === totalPages, false);
        createButton('›', Math.min(currentPage + 1, totalPages), false, currentPage === totalPages);
    }

    function renderProducts() {
        const filteredProducts = getFilteredProducts();
        const start = (currentPage - 1) * productsPerPage;
        const end = start + productsPerPage;

        allProducts.forEach(function (product) {
            product.style.display = 'none';
        });

        filteredProducts.slice(start, end).forEach(function (product) {
            product.style.display = '';
            grid.appendChild(product);
        });

        if (noProducts) {
            noProducts.style.display = filteredProducts.length === 0 ? 'block' : 'none';
        }

        renderPagination(filteredProducts.length);
    }

    categoryLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            categoryLinks.forEach(function (item) { item.classList.remove('active'); });
            this.classList.add('active');
            currentCategory = this.dataset.category;
            currentPage = 1;
            renderProducts();
        });
    });

    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            currentPage = 1;
            renderProducts();
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            currentPage = 1;
            renderProducts();
        });
    }

    renderProducts();
});
