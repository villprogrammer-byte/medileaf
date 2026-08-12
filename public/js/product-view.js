document.addEventListener("DOMContentLoaded", function () {
    "use strict";

    const mainImage = document.getElementById("mlProductMainImg");
    const galleryCaption = document.getElementById("mlGalleryCaption");

    const galleryThumbs = Array.from(
        document.querySelectorAll(".ml-product-angle-thumb")
    );

    const galleryPrev = document.getElementById("mlGalleryPrev");
    const galleryNext = document.getElementById("mlGalleryNext");

    const colourSelect = document.getElementById(
        "mlProductColourSelect"
    );

    const colourTrigger = document.getElementById(
        "mlProductColourTrigger"
    );

    const dropdownOptions = Array.from(
        document.querySelectorAll(".ml-product-variant-option")
    );

    const colourCards = Array.from(
        document.querySelectorAll(".ml-colour-card")
    );

    const selectedColourDot = document.getElementById(
        "mlSelectedColourDot"
    );

    const variantName = document.getElementById("mlVariantName");
    const variantSku = document.getElementById("mlVariantSku");
    const variantStock = document.getElementById("mlVariantStock");
    const variantPrice = document.getElementById("mlVariantPrice");
    const selectedVariantId = document.getElementById(
        "selectedVariantId"
    );

    const quantityInput = document.getElementById("productQty");
    const addButton = document.getElementById("productAddToBag");
    const minusButton = document.getElementById("qtyMinus");
    const plusButton = document.getElementById("qtyPlus");

    let currentGalleryIndex = 0;

    function switchMainImage(imageUrl, label) {
        if (!mainImage || !imageUrl) {
            return;
        }

        mainImage.classList.add("is-switching");

        window.setTimeout(function () {
            mainImage.src = imageUrl;

            if (label) {
                mainImage.alt = label;
            }

            if (galleryCaption) {
                galleryCaption.textContent = label || "Product View";
            }

            mainImage.classList.remove("is-switching");
        }, 120);
    }

    function showGalleryImage(index) {
        if (!galleryThumbs.length) {
            return;
        }

        currentGalleryIndex = (
            index + galleryThumbs.length
        ) % galleryThumbs.length;

        const selectedThumb = galleryThumbs[currentGalleryIndex];

        galleryThumbs.forEach(function (thumb, thumbIndex) {
            thumb.classList.toggle(
                "active",
                thumbIndex === currentGalleryIndex
            );
        });

        switchMainImage(
            selectedThumb.dataset.galleryImage,
            selectedThumb.dataset.galleryLabel
        );

        selectedThumb.scrollIntoView({
            behavior: "smooth",
            block: "nearest",
            inline: "nearest",
        });
    }

    galleryThumbs.forEach(function (thumb, index) {
        thumb.addEventListener("click", function () {
            showGalleryImage(index);
        });
    });

    galleryPrev?.addEventListener("click", function () {
        showGalleryImage(currentGalleryIndex - 1);
    });

    galleryNext?.addEventListener("click", function () {
        showGalleryImage(currentGalleryIndex + 1);
    });

    function closeColourDropdown() {
        if (!colourSelect || !colourTrigger) {
            return;
        }

        colourSelect.classList.remove("open");
        colourTrigger.setAttribute("aria-expanded", "false");
    }

    colourTrigger?.addEventListener("click", function () {
        if (!colourSelect) {
            return;
        }

        const isOpen = colourSelect.classList.toggle("open");

        colourTrigger.setAttribute(
            "aria-expanded",
            isOpen ? "true" : "false"
        );
    });

    document.addEventListener("click", function (event) {
        if (
            colourSelect &&
            !colourSelect.contains(event.target)
        ) {
            closeColourDropdown();
        }
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            closeColourDropdown();
        }
    });

    function syncActiveVariant(variantId) {
        dropdownOptions.forEach(function (option) {
            option.classList.toggle(
                "active",
                option.dataset.variantId === variantId
            );
        });

        colourCards.forEach(function (card) {
            card.classList.toggle(
                "active",
                card.dataset.variantId === variantId
            );
        });
    }

    function selectVariant(element) {
        const stock = Math.max(
            0,
            Number(element.dataset.stock || 0)
        );

        const price = Number(element.dataset.price || 0);
        const name = element.dataset.name || "Selected Colour";
        const colour = element.dataset.color || "#31A050";
        const sku = element.dataset.sku || "Not available";
        const image = element.dataset.image || "";
        const id = element.dataset.variantId || "";

        syncActiveVariant(id);

        if (variantName) {
            variantName.textContent = name;
        }

        if (selectedColourDot) {
            selectedColourDot.style.background = colour;
        }

        if (variantSku) {
            variantSku.textContent = sku;
        }

        if (variantStock) {
            variantStock.classList.remove(
                "in-stock",
                "low-stock",
                "out-stock"
            );

            if (stock <= 0) {
                variantStock.classList.add("out-stock");

                variantStock.innerHTML = `
                    <i class="bi bi-x-circle-fill"></i>
                    Out of Stock
                `;
            } else if (stock <= 5) {
                variantStock.classList.add("low-stock");

                variantStock.innerHTML = `
                    <i class="bi bi-check-circle-fill"></i>
                    In Stock
                    <small class="ml-low-stock-message">
                        Hurry, only ${stock} left
                    </small>
                `;
            } else {
                variantStock.classList.add("in-stock");

                variantStock.innerHTML = `
                    <i class="bi bi-check-circle-fill"></i>
                    In Stock
                `;
            }
        }

        if (variantPrice) {
            variantPrice.textContent = `A$${price.toFixed(2)}`;
        }

        if (selectedVariantId) {
            selectedVariantId.value = id;
        }

        if (quantityInput) {
            quantityInput.value = "1";
            quantityInput.max = String(Math.max(stock, 1));
        }

        if (addButton) {
            addButton.disabled = stock <= 0;
        }

        galleryThumbs.forEach(function (thumb) {
            thumb.classList.remove("active");
        });

        if (image) {
            switchMainImage(image, `${name} Colour`);
        }

        closeColourDropdown();
    }

    dropdownOptions.forEach(function (option) {
        option.addEventListener("click", function () {
            selectVariant(option);
        });
    });

    colourCards.forEach(function (card) {
        card.addEventListener("click", function () {
            selectVariant(card);
        });
    });

    function clampQuantity() {
        if (!quantityInput) {
            return;
        }

        const minimum = Math.max(
            1,
            Number(quantityInput.min || 1)
        );

        const maximum = Math.max(
            minimum,
            Number(quantityInput.max || minimum)
        );

        const value = Math.min(
            maximum,
            Math.max(
                minimum,
                Number(quantityInput.value || minimum)
            )
        );

        quantityInput.value = String(value);
    }

    minusButton?.addEventListener("click", function () {
        if (!quantityInput) {
            return;
        }

        quantityInput.value = String(
            Number(quantityInput.value || 1) - 1
        );

        clampQuantity();
    });

    plusButton?.addEventListener("click", function () {
        if (!quantityInput) {
            return;
        }

        quantityInput.value = String(
            Number(quantityInput.value || 1) + 1
        );

        clampQuantity();
    });

    quantityInput?.addEventListener("input", clampQuantity);
    quantityInput?.addEventListener("blur", clampQuantity);

    /*
|--------------------------------------------------------------------------
| Add Selected Variant to Cart
|--------------------------------------------------------------------------
*/

    addButton?.addEventListener("click", function () {
        if (
            !window.MedileafCart ||
            typeof window.MedileafCart.addToCart !== "function"
        ) {
            console.error("MediLeaf cart is not available.");

            alert(
                "Cart could not be loaded. Please refresh the page and try again."
            );

            return;
        }

        const selectedOption =
            dropdownOptions.find(function (option) {
                return option.classList.contains("active");
            }) ||
            colourCards.find(function (card) {
                return card.classList.contains("active");
            });

        const hasVariants =
            dropdownOptions.length > 0 ||
            colourCards.length > 0;

        if (hasVariants && !selectedOption) {
            alert("Please select a colour.");

            return;
        }

        const selectedStock = Math.max(
            0,
            Number(
                selectedOption?.dataset.stock ??
                window.mlProductConfig?.stock ??
                0
            )
        );

        const selectedQuantity = Math.max(
            1,
            Number(quantityInput?.value || 1)
        );

        if (selectedStock <= 0) {
            alert("This colour is currently out of stock.");

            return;
        }

        if (selectedQuantity > selectedStock) {
            alert(
                `Only ${selectedStock} item(s) are currently available.`
            );

            return;
        }

        const selectedPrice = Number(
            selectedOption?.dataset.price ??
            window.mlProductConfig?.price ??
            0
        );

        const selectedImage =
            selectedOption?.dataset.image ||
            mainImage?.src ||
            window.mlProductConfig?.image ||
            "";

        const productName =
            window.mlProductConfig?.name ||
            document
                .querySelector(".ml-product-info h1")
                ?.textContent
                ?.trim() ||
            "";

        window.MedileafCart.addToCart({
            id: Number(
                window.mlProductConfig?.id || 0
            ),

            variantId: selectedOption
                ? Number(selectedOption.dataset.variantId || 0)
                : null,

            name: productName,

            colour:
                selectedOption?.dataset.name ||
                "",

            sku:
                selectedOption?.dataset.sku ||
                window.mlProductConfig?.sku ||
                "",

            price: selectedPrice,

            image: selectedImage,

            qty: selectedQuantity,

            stock: selectedStock
        });
    });

});
