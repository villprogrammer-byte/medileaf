document.addEventListener("DOMContentLoaded", function () {
    "use strict";

    const mainImage = document.getElementById("mlProductMainImg");
    const galleryCaption = document.getElementById("mlGalleryCaption");

    const galleryThumbs = Array.from(
        document.querySelectorAll(".ml-product-angle-thumb")
    );

    const galleryPrev = document.getElementById("mlGalleryPrev");
    const galleryNext = document.getElementById("mlGalleryNext");

    const colourSelect = document.getElementById("mlProductColourSelect");
    const colourTrigger = document.getElementById("mlProductColourTrigger");

    const dropdownOptions = Array.from(
        document.querySelectorAll(".ml-product-variant-option")
    );

    const colourCards = Array.from(
        document.querySelectorAll(".ml-colour-card")
    );

    const selectedColourDot = document.getElementById("mlSelectedColourDot");
    const variantName = document.getElementById("mlVariantName");
    const variantSku = document.getElementById("mlVariantSku");
    const variantStock = document.getElementById("mlVariantStock");
    const variantPrice = document.getElementById("mlVariantPrice");

    const selectedVariantId = document.getElementById("selectedVariantId");

    const quantityInput = document.getElementById("productQty");
    const addButton = document.getElementById("productAddToBag");
    const minusButton = document.getElementById("qtyMinus");
    const plusButton = document.getElementById("qtyPlus");

    let currentGalleryIndex = 0;


    /*
    |--------------------------------------------------------------------------
    | MAIN IMAGE SWITCH
    |--------------------------------------------------------------------------
    */

    function switchMainImage(imageUrl, label, altText) {
        if (!mainImage || !imageUrl) {
            return;
        }

        mainImage.classList.add("is-switching");

        window.setTimeout(function () {
            mainImage.src = imageUrl;

            mainImage.alt =
                altText ||
                label ||
                "Product image";

            if (galleryCaption) {
                galleryCaption.textContent =
                    label || "Product View";
            }

            mainImage.classList.remove("is-switching");
        }, 120);
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW GALLERY IMAGE
    |--------------------------------------------------------------------------
    */

    function showGalleryImage(index) {
        if (!galleryThumbs.length) {
            return;
        }

        currentGalleryIndex =
            (index + galleryThumbs.length) %
            galleryThumbs.length;

        const selectedThumb =
            galleryThumbs[currentGalleryIndex];

        galleryThumbs.forEach(function (thumb, thumbIndex) {
            thumb.classList.toggle(
                "active",
                thumbIndex === currentGalleryIndex
            );
        });

        switchMainImage(
            selectedThumb.dataset.galleryImage,
            selectedThumb.dataset.galleryLabel,
            selectedThumb.dataset.galleryAlt
        );

        selectedThumb.scrollIntoView({
            behavior: "smooth",
            block: "nearest",
            inline: "nearest",
        });
    }


    /*
    |--------------------------------------------------------------------------
    | GALLERY EVENTS
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | COLOUR DROPDOWN
    |--------------------------------------------------------------------------
    */

    function closeColourDropdown() {
        if (!colourSelect || !colourTrigger) {
            return;
        }

        colourSelect.classList.remove("open");

        colourTrigger.setAttribute(
            "aria-expanded",
            "false"
        );
    }


    colourTrigger?.addEventListener("click", function () {
        if (!colourSelect) {
            return;
        }

        const isOpen =
            colourSelect.classList.toggle("open");

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


    /*
    |--------------------------------------------------------------------------
    | SYNC ACTIVE VARIANT
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | SELECT VARIANT
    |--------------------------------------------------------------------------
    */

    function selectVariant(element) {
        const stock = Math.max(
            0,
            Number(element.dataset.stock || 0)
        );

        const price =
            Number(element.dataset.price || 0);

        const name =
            element.dataset.name ||
            "Selected Colour";

        const colour =
            element.dataset.color ||
            "#31A050";

        const sku =
            element.dataset.sku ||
            "Not available";

        const image =
            element.dataset.image || "";

        const imageAlt =
            element.dataset.imageAlt ||
            `${name} product image`;

        const id =
            element.dataset.variantId || "";


        /*
        |--------------------------------------------------------------------------
        | Active State
        |--------------------------------------------------------------------------
        */

        syncActiveVariant(id);


        /*
        |--------------------------------------------------------------------------
        | Selected Colour
        |--------------------------------------------------------------------------
        */

        if (variantName) {
            variantName.textContent = name;
        }

        if (selectedColourDot) {
            selectedColourDot.style.background =
                colour;
        }


        /*
        |--------------------------------------------------------------------------
        | SKU
        |--------------------------------------------------------------------------
        */

        if (variantSku) {
            variantSku.textContent = sku;
        }


        /*
        |--------------------------------------------------------------------------
        | Stock
        |--------------------------------------------------------------------------
        */

        if (variantStock) {
            variantStock.classList.remove(
                "in-stock",
                "low-stock",
                "out-stock"
            );

            if (stock <= 0) {
                variantStock.classList.add(
                    "out-stock"
                );

                variantStock.innerHTML = `
                    <i class="bi bi-x-circle-fill"></i>
                    Out of Stock
                `;
            } else if (stock <= 5) {
                variantStock.classList.add(
                    "low-stock"
                );

                variantStock.innerHTML = `
                    <i class="bi bi-check-circle-fill"></i>
                    In Stock

                    <small class="ml-low-stock-message">
                        Hurry, only ${stock} left
                    </small>
                `;
            } else {
                variantStock.classList.add(
                    "in-stock"
                );

                variantStock.innerHTML = `
                    <i class="bi bi-check-circle-fill"></i>
                    In Stock
                `;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Price
        |--------------------------------------------------------------------------
        */

        if (variantPrice) {
            variantPrice.textContent =
                `A$${price.toFixed(2)}`;
        }


        /*
        |--------------------------------------------------------------------------
        | Selected Variant ID
        |--------------------------------------------------------------------------
        */

        if (selectedVariantId) {
            selectedVariantId.value = id;
        }


        /*
        |--------------------------------------------------------------------------
        | Quantity
        |--------------------------------------------------------------------------
        */

        if (quantityInput) {
            quantityInput.value = "1";

            quantityInput.max =
                String(
                    Math.max(stock, 1)
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Add Button
        |--------------------------------------------------------------------------
        */

        if (addButton) {
            addButton.disabled =
                stock <= 0;
        }


        /*
        |--------------------------------------------------------------------------
        | Variant Main Image
        |--------------------------------------------------------------------------
        */

        galleryThumbs.forEach(function (thumb) {
            thumb.classList.remove("active");
        });

        if (image) {
            switchMainImage(
                image,
                `${name} Colour`,
                imageAlt
            );
        }


        closeColourDropdown();
    }


    /*
    |--------------------------------------------------------------------------
    | VARIANT EVENTS
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | QUANTITY CLAMP
    |--------------------------------------------------------------------------
    */

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
            Number(
                quantityInput.max ||
                minimum
            )
        );

        const value = Math.min(
            maximum,
            Math.max(
                minimum,
                Number(
                    quantityInput.value ||
                    minimum
                )
            )
        );

        quantityInput.value =
            String(value);
    }


    /*
    |--------------------------------------------------------------------------
    | QUANTITY EVENTS
    |--------------------------------------------------------------------------
    */

    minusButton?.addEventListener("click", function () {
        if (!quantityInput) {
            return;
        }

        quantityInput.value = String(
            Number(
                quantityInput.value || 1
            ) - 1
        );

        clampQuantity();
    });


    plusButton?.addEventListener("click", function () {
        if (!quantityInput) {
            return;
        }

        quantityInput.value = String(
            Number(
                quantityInput.value || 1
            ) + 1
        );

        clampQuantity();
    });


    quantityInput?.addEventListener(
        "input",
        clampQuantity
    );

    quantityInput?.addEventListener(
        "blur",
        clampQuantity
    );


    /*
    |--------------------------------------------------------------------------
    | ADD SELECTED VARIANT TO CART
    |--------------------------------------------------------------------------
    */

    addButton?.addEventListener("click", function () {
        if (
            !window.MedileafCart ||
            typeof window.MedileafCart.addToCart !==
            "function"
        ) {
            console.error(
                "MediLeaf cart is not available."
            );

            alert(
                "Cart could not be loaded. Please refresh the page and try again."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Find Selected Variant
        |--------------------------------------------------------------------------
        */

        const selectedOption =
            dropdownOptions.find(function (option) {
                return option.classList.contains(
                    "active"
                );
            }) ||
            colourCards.find(function (card) {
                return card.classList.contains(
                    "active"
                );
            });


        if (!selectedOption) {
            alert(
                "Please select a colour."
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Stock
        |--------------------------------------------------------------------------
        */

        const selectedStock = Math.max(
            0,
            Number(
                selectedOption.dataset.stock ||
                0
            )
        );


        const selectedQuantity = Math.max(
            1,
            Number(
                quantityInput?.value ||
                1
            )
        );


        if (selectedStock <= 0) {
            alert(
                "This colour is currently out of stock."
            );

            return;
        }


        if (
            selectedQuantity >
            selectedStock
        ) {
            alert(
                `Only ${selectedStock} item(s) are currently available.`
            );

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Price
        |--------------------------------------------------------------------------
        */

        const selectedPrice = Number(
            selectedOption.dataset.price ||
            0
        );


        /*
        |--------------------------------------------------------------------------
        | Image
        |--------------------------------------------------------------------------
        */

        const selectedImage =
            selectedOption.dataset.image ||
            mainImage?.src ||
            "";


        /*
        |--------------------------------------------------------------------------
        | Product Name
        |--------------------------------------------------------------------------
        */

        const productName =
            window.mlProductConfig?.name ||
            document
                .querySelector(
                    ".ml-product-info h1"
                )
                ?.textContent
                ?.trim() ||
            "";


        /*
        |--------------------------------------------------------------------------
        | Add To Cart
        |--------------------------------------------------------------------------
        */

        window.MedileafCart.addToCart({
            id: Number(
                window.mlProductConfig?.id ||
                0
            ),

            variantId: Number(
                selectedOption.dataset.variantId ||
                0
            ),

            name: productName,

            colour:
                selectedOption.dataset.name ||
                "Default",

            sku:
                selectedOption.dataset.sku ||
                "",

            price: selectedPrice,

            image: selectedImage,

            qty: selectedQuantity,

            stock: selectedStock,
        });
    });
});