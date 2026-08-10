document.addEventListener("DOMContentLoaded", function () {
    "use strict";

    const categoryLinks = document.querySelectorAll(".ml-shop-v2-category-scroll a");
    const searchInput = document.getElementById("mlShopSearch");
    const sortSelect = document.getElementById("mlShopSort");
    const grid = document.getElementById("mlShopGrid");
    const pagination = document.getElementById("mlShopPagination");
    const noProducts = document.getElementById("mlShopNoProducts");
    const sortWrapper = document.getElementById("mlShopSortSelect");
    const sortTrigger = document.getElementById("mlShopSortTrigger");
    const sortLabel = document.getElementById("mlShopSortLabel");
    const sortOptionButtons = document.querySelectorAll(".ml-sort-option");

    if (!grid || !pagination) {
        return;
    }

    const productsPerPage = 8;

    let currentCategory = "all";
    let currentPage = 1;

    const allProducts = Array.from(grid.querySelectorAll(".ml-shop-product-item"));

    function getFilteredProducts() {
        const searchValue = searchInput ? searchInput.value.toLowerCase().trim() : "";

        const filtered = allProducts.filter(function (product) {
            const productCategory = product.dataset.category || "";
            const productName = (product.dataset.name || "").toLowerCase();

            const categoryMatch = currentCategory === "all" || productCategory === currentCategory;
            const nameMatch = productName.includes(searchValue);

            return categoryMatch && nameMatch;
        });

        if (!sortSelect) {
            return filtered;
        }

        const sortValue = sortSelect.value;

        filtered.sort(function (a, b) {
            const nameA = (a.dataset.name || "").toLowerCase();
            const nameB = (b.dataset.name || "").toLowerCase();

            const priceA = parseFloat(a.dataset.price) || 0;
            const priceB = parseFloat(b.dataset.price) || 0;

            const idA = parseInt(a.dataset.id, 10) || 0;
            const idB = parseInt(b.dataset.id, 10) || 0;

            switch (sortValue) {
                case "low":
                    return priceA - priceB;
                case "high":
                    return priceB - priceA;
                case "az":
                    return nameA.localeCompare(nameB);
                case "latest":
                    return idB - idA;
                default:
                    return idA - idB;
            }
        });

        return filtered;
    }

    function renderPagination(totalProducts) {
        const totalPages = Math.ceil(totalProducts / productsPerPage);

        pagination.innerHTML = "";

        if (totalPages <= 1) {
            return;
        }

        if (currentPage > totalPages) {
            currentPage = totalPages;
        }

        function createButton(text, page, active = false, disabled = false) {
            const button = document.createElement("button");

            button.type = "button";
            button.textContent = text;
            button.disabled = disabled;

            if (active) {
                button.classList.add("active");
            }

            button.addEventListener("click", function () {
                if (disabled || page === currentPage) {
                    return;
                }

                currentPage = page;

                renderProducts();

                grid.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                });
            });

            pagination.appendChild(button);
        }

        createButton("‹", Math.max(currentPage - 1, 1), false, currentPage === 1);

        createButton("1", 1, currentPage === 1);

        if (currentPage > 3) {
            createButton("...", currentPage, false, true);
        }

        const startPage = Math.max(2, currentPage - 1);
        const endPage = Math.min(totalPages - 1, currentPage + 1);

        for (let page = startPage; page <= endPage; page++) {
            createButton(String(page), page, currentPage === page);
        }

        if (currentPage < totalPages - 2) {
            createButton("...", currentPage, false, true);
        }

        if (totalPages > 1) {
            createButton(String(totalPages), totalPages, currentPage === totalPages);
        }

        createButton("›", Math.min(currentPage + 1, totalPages), false, currentPage === totalPages);
    }

    function renderProducts() {
        const filteredProducts = getFilteredProducts();

        const start = (currentPage - 1) * productsPerPage;
        const end = start + productsPerPage;

        allProducts.forEach(function (product) {
            product.style.display = "none";
        });

        filteredProducts.forEach(function (product) {
            grid.appendChild(product);
        });

        filteredProducts.slice(start, end).forEach(function (product) {
            product.style.display = "";
        });

        if (noProducts) {
            noProducts.style.display = filteredProducts.length === 0 ? "block" : "none";
        }

        renderPagination(filteredProducts.length);
    }

    categoryLinks.forEach(function (link) {
        link.addEventListener("click", function (event) {
            event.preventDefault();

            categoryLinks.forEach(function (item) {
                item.classList.remove("active");
            });

            this.classList.add("active");

            currentCategory = this.dataset.category || "all";

            currentPage = 1;

            renderProducts();
        });
    });

    searchInput?.addEventListener("input", function () {
        currentPage = 1;

        renderProducts();
    });

    sortSelect?.addEventListener("change", function () {
        currentPage = 1;

        renderProducts();
    });

    if (sortWrapper && sortTrigger && sortSelect) {
        sortTrigger.addEventListener("click", function (event) {
            event.preventDefault();
            event.stopPropagation();

            const isOpen = sortWrapper.classList.contains("open");

            sortWrapper.classList.toggle("open", !isOpen);

            sortTrigger.setAttribute("aria-expanded", String(!isOpen));
        });

        sortOptionButtons.forEach(function (option) {
            option.addEventListener("click", function (event) {
                event.preventDefault();
                event.stopPropagation();

                const value = this.dataset.value;

                sortOptionButtons.forEach(function (item) {
                    item.classList.remove("active");
                });

                this.classList.add("active");

                sortSelect.value = value;

                if (sortLabel) {
                    sortLabel.textContent = this.textContent.trim();
                }

                sortWrapper.classList.remove("open");

                sortTrigger.setAttribute("aria-expanded", "false");

                currentPage = 1;

                renderProducts();
            });
        });

        document.addEventListener("click", function (event) {
            if (!sortWrapper.contains(event.target)) {
                sortWrapper.classList.remove("open");

                sortTrigger.setAttribute("aria-expanded", "false");
            }
        });

        document.addEventListener("keydown", function (event) {
            if (event.key === "Escape") {
                sortWrapper.classList.remove("open");

                sortTrigger.setAttribute("aria-expanded", "false");
            }
        });
    }

    grid.addEventListener("click", function (event) {
        const button = event.target.closest(".add-to-bag-btn");

        if (!button || button.disabled) {
            return;
        }

        const card = button.closest(".ml-shop-product-item");

        if (!card) {
            return;
        }

        if (!window.MedileafCart || typeof window.MedileafCart.addToCart !== "function") {
            console.warn("MedileafCart is not available. Make sure cart.js is loaded before store.js.");

            return;
        }

        const imageElement = card.querySelector(".ml-shop-v2-img img");

        const productName =
            card.querySelector(".ml-shop-v2-title-link")?.textContent?.trim() ||
            card.dataset.name ||
            "";

        const product = {
            id: Number(card.dataset.id || 0),
            name: productName,
            price: Number(card.dataset.price) || 0,
            image: imageElement ? imageElement.getAttribute("src") : "",
            qty: 1,
        };

        window.MedileafCart.addToCart(product);
    });

    renderProducts();
});