document.addEventListener("DOMContentLoaded", function () {

    // Blade se pass ki gayi dynamic product config
    const productConfig = window.mlProductConfig || {};

    const qtyInput = document.getElementById("productQty");
    const qtyMinus = document.getElementById("qtyMinus");
    const qtyPlus = document.getElementById("qtyPlus");

    const addBtn = document.getElementById("productAddToBag");
    const buyNowBtn = document.getElementById("productBuyNow");

    const mainImg = document.getElementById("mlProductMainImg");
    const mainBox = document.getElementById("mlProductMainBox");

    const thumbs = document.querySelectorAll(
        ".ml-product-thumbs button[data-image]"
    );

    const colorDot = document.getElementById("currentColorDot");

    const customSelect = document.getElementById(
        "mlCustomColorSelect"
    );

    const customTrigger = customSelect
        ? customSelect.querySelector(
            ".ml-custom-select-trigger"
        )
        : null;

    const selectedText = document.getElementById(
        "mlSelectedColor"
    );

    const customOptions = customSelect
        ? customSelect.querySelectorAll(
            ".ml-custom-option"
        )
        : [];

    const scrollToDescription = document.getElementById(
        "scrollToDescription"
    );

    const productDescription = document.getElementById(
        "productDescription"
    );

    function getCurrentProduct() {

        let selectedQuantity = qtyInput
            ? Number(qtyInput.value)
            : 1;

        if (
            !Number.isFinite(selectedQuantity) ||
            selectedQuantity < 1
        ) {
            selectedQuantity = 1;

            if (qtyInput) {
                qtyInput.value = 1;
            }
        }

        const selectedColour = selectedText
            ? selectedText.textContent.trim()
            : "";

        return {

            id: Number(productConfig.id),

            name: productConfig.name || "",

            price: Number(productConfig.price) || 0,

            image: mainImg
                ? mainImg.src
                : productConfig.image,

            colour: selectedColour,

            qty: selectedQuantity

        };
    }

    /*
    |--------------------------------------------------------------------------
    | Sync helpers (Option A: thumbs + dropdown represent the SAME colours,
    | so selecting one must visually highlight the matching entry in the other)
    |--------------------------------------------------------------------------
    */

    function highlightThumbOnly(index) {

        const button = thumbs[index];

        if (!button) {
            return;
        }

        thumbs.forEach(function (item) {
            item.classList.remove("active");
            item.style.borderColor = "transparent";
            item.style.background = "#fff";
        });

        const color = button.dataset.color || "";
        const background = button.dataset.bg || "";

        button.classList.add("active");

        if (color) {
            button.style.borderColor = color;
        }

        if (background) {
            button.style.background = background;
        }
    }

    function highlightCustomOptionOnly(index) {

        const option = customOptions[index];

        if (!option) {
            return;
        }

        customOptions.forEach(function (item) {
            item.classList.remove("active");
        });

        option.classList.add("active");
    }

    function resetColourSelection() {

        thumbs.forEach(function (item) {
            item.classList.remove("active");
            item.style.borderColor = "transparent";
            item.style.background = "#fff";
        });

        customOptions.forEach(function (option) {
            option.classList.remove("active");
        });

        const firstOption = customOptions[0];

        if (!firstOption) {
            return;
        }

        firstOption.classList.add("active");

        const firstColor = firstOption.dataset.color || "#31a050";
        const firstName = firstOption.dataset.name || "Default";
        const firstImage = firstOption.dataset.image || productConfig.image;

        if (selectedText) {
            selectedText.textContent = firstName;
        }

        if (colorDot) {
            colorDot.style.background = firstColor;
            colorDot.style.boxShadow =
                "0 0 0 1px rgba(0,0,0,.08), 0 4px 14px " +
                firstColor +
                "55";
        }

        if (mainImg && firstImage) {
            mainImg.src = firstImage;
        }

        // Keep thumb #0 visually in sync with the default colour
        highlightThumbOnly(0);
    }

    function setActiveThumb(index) {

        const button = thumbs[index];

        if (!button) {
            return;
        }

        thumbs.forEach(function (item) {

            item.classList.remove("active");
            item.style.borderColor = "transparent";
            item.style.background = "#fff";

        });

        const image = button.dataset.image || "";

        const color = button.dataset.color || "";

        const background = button.dataset.bg || "";

        button.classList.add("active");

        if (color) {
            button.style.borderColor = color;
        }

        if (background) {
            button.style.background = background;
        }

        if (mainBox && background) {
            mainBox.style.background = background;
        }

        if (colorDot) {

            if (color) {

                colorDot.style.background = color;

                colorDot.style.boxShadow =
                    "0 0 0 1px rgba(0,0,0,.08), " +
                    "0 4px 14px " +
                    color +
                    "55";

            } else {

                colorDot.style.background = "transparent";
                colorDot.style.boxShadow = "none";

            }
        }

        if (
            customOptions[index] &&
            selectedText
        ) {
            selectedText.textContent =
                customOptions[index]
                    .textContent
                    .trim();
        }

        if (mainImg && image) {

            mainImg.style.opacity = "0";

            setTimeout(function () {

                mainImg.src = image;
                mainImg.style.opacity = "1";

            }, 150);
        }

        // Keep the matching dropdown option highlighted too
        highlightCustomOptionOnly(index);
    }


    function setActiveColour(option) {

        if (!option) {
            return;
        }

        customOptions.forEach(function (item) {
            item.classList.remove("active");
        });

        option.classList.add("active");

        const color = option.dataset.color || "#31a050";
        const colorName = option.dataset.name || "Default";
        const image = option.dataset.image || productConfig.image;

        if (selectedText) {
            selectedText.textContent = colorName;
        }

        if (colorDot) {
            colorDot.style.background = color;
            colorDot.style.boxShadow =
                "0 0 0 1px rgba(0,0,0,.08), 0 4px 14px " +
                color +
                "55";
        }

        if (mainBox) {
            mainBox.style.background = color + "12";
        }

        if (mainImg && image) {

            mainImg.style.opacity = "0";

            setTimeout(function () {
                mainImg.src = image;
                mainImg.alt = colorName;
                mainImg.style.opacity = "1";
            }, 150);
        }

        if (customSelect) {
            customSelect.classList.remove("active");
        }

        // Keep the matching thumb highlighted too
        const index = Number(option.dataset.index);

        if (Number.isFinite(index)) {
            highlightThumbOnly(index);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Product thumbnail selection
    |--------------------------------------------------------------------------
    */

    thumbs.forEach(function (thumb, index) {

        thumb.addEventListener("click", function () {

            setActiveThumb(index);

        });

    });

    /*
    |--------------------------------------------------------------------------
    | Custom colour dropdown
    |--------------------------------------------------------------------------
    */

    if (customTrigger && customSelect) {

        customTrigger.addEventListener(
            "click",
            function (event) {

                event.stopPropagation();

                customSelect.classList.toggle(
                    "active"
                );

            }
        );

    }

    customOptions.forEach(function (option) {

        option.addEventListener("click", function (event) {

            event.stopPropagation();

            setActiveColour(this);

        });

    });

    document.addEventListener("click", function () {

        if (customSelect) {
            customSelect.classList.remove("active");
        }

    });

    /*
    |--------------------------------------------------------------------------
    | | Select first colour by default
    |--------------------------------------------------------------------------
    */

    resetColourSelection();

    /*
    |--------------------------------------------------------------------------
    | Quantity controls
    |--------------------------------------------------------------------------
    */

    if (qtyMinus && qtyInput) {

        qtyMinus.addEventListener(
            "click",
            function () {

                let value = Number(qtyInput.value);

                if (
                    !Number.isFinite(value) ||
                    value < 1
                ) {
                    value = 1;
                }

                if (value > 1) {
                    qtyInput.value = value - 1;
                }

            }
        );

    }

    if (qtyPlus && qtyInput) {

        qtyPlus.addEventListener(
            "click",
            function () {

                let value = Number(qtyInput.value);

                if (
                    !Number.isFinite(value) ||
                    value < 1
                ) {
                    value = 1;
                }

                qtyInput.value = value + 1;

            }
        );

    }

    if (qtyInput) {

        qtyInput.addEventListener(
            "change",
            function () {

                let value = Number(this.value);

                if (
                    !Number.isFinite(value) ||
                    value < 1
                ) {
                    this.value = 1;
                }

            }
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Add to Bag
    |--------------------------------------------------------------------------
    */

    if (addBtn) {

        addBtn.addEventListener(
            "click",
            function () {

                if (!window.MedileafCart) {
                    console.error(
                        "MedileafCart is not loaded."
                    );

                    return;
                }

                window.MedileafCart.addToCart(
                    getCurrentProduct()
                );

            }
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Buy Now
    |--------------------------------------------------------------------------
    */

    if (buyNowBtn) {

        buyNowBtn.addEventListener(
            "click",
            function () {

                if (window.MedileafCart) {

                    window.MedileafCart.addToCart(
                        getCurrentProduct(),
                        {
                            openDrawer: false,
                            showToast: false
                        }
                    );

                }

                if (productConfig.checkoutUrl) {

                    window.location.href =
                        productConfig.checkoutUrl;

                }

            }
        );

    }

    /*
    |--------------------------------------------------------------------------
    | Scroll to product description
    |--------------------------------------------------------------------------
    */

    if (
        scrollToDescription &&
        productDescription
    ) {

        scrollToDescription.addEventListener(
            "click",
            function () {

                productDescription.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });

            }
        );

    }

});