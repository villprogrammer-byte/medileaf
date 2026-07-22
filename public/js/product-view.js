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

        return {
            id: Number(productConfig.id),
            name: productConfig.name || "",
            price: Number(productConfig.price) || 0,

            image: mainImg
                ? mainImg.getAttribute("src")
                : productConfig.image,

            qty: selectedQuantity
        };
    }

    function resetColourSelection() {

        thumbs.forEach(function (item) {

            item.classList.remove("active");
            item.style.borderColor = "transparent";
            item.style.background = "#fff";

        });

        if (colorDot) {
            colorDot.style.background = "transparent";
            colorDot.style.boxShadow = "none";
        }

        if (mainBox) {
            mainBox.style.background = "";
        }
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

        option.addEventListener(
            "click",
            function (event) {

                event.stopPropagation();

                const index = Number(
                    this.dataset.index
                );

                if (customSelect) {
                    customSelect.classList.remove(
                        "active"
                    );
                }

                setActiveThumb(index);

            }
        );

    });

    document.addEventListener("click", function () {

        if (customSelect) {
            customSelect.classList.remove("active");
        }

    });

    /*
    |--------------------------------------------------------------------------
    | No default colour selection
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