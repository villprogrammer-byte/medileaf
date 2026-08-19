document.addEventListener("DOMContentLoaded", function () {
    "use strict";

    /*
    |--------------------------------------------------------------------------
    | Mobile Admin Sidebar
    |--------------------------------------------------------------------------
    */

    initialiseAdminSidebar();


    /*
    |--------------------------------------------------------------------------
    | Product Admin
    |--------------------------------------------------------------------------
    */

    initialiseProductSlug();
    initialiseFeaturedImage();
    initialiseOgImage();
    initialiseGalleryManager();


    /*
    |--------------------------------------------------------------------------
    | ADMIN SIDEBAR
    |--------------------------------------------------------------------------
    */

    function initialiseAdminSidebar() {
        const menuButton =
            document.getElementById("mlAdminMenuToggle");

        const sidebar =
            document.querySelector(".ml-admin-sidebar");

        if (!menuButton || !sidebar) {
            return;
        }

        menuButton.addEventListener("click", function () {
            sidebar.classList.toggle("show");
        });


        /*
        | Close sidebar when clicking outside on mobile
        */

        document.addEventListener("click", function (event) {
            if (window.innerWidth > 991) {
                return;
            }

            if (
                !sidebar.classList.contains("show") ||
                sidebar.contains(event.target) ||
                menuButton.contains(event.target)
            ) {
                return;
            }

            sidebar.classList.remove("show");
        });
    }


    /*
    |--------------------------------------------------------------------------
    | PRODUCT SLUG + URL PREVIEW
    |--------------------------------------------------------------------------
    |
    | Final product URL:
    |
    | /vaporisers/mighty-plus-medic
    |
    */

    function initialiseProductSlug() {
        const productName =
            document.getElementById("productName");

        const productSlug =
            document.getElementById("productSlug");

        const productCategory =
            document.querySelector(
                '.ml-custom-select[data-name="category"] input[name="category"]'
            );

        const productUrlPreview =
            document.getElementById("productUrlPreview");

        if (!productSlug) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Slug helper
        |--------------------------------------------------------------------------
        */

        function slugify(value) {
            return String(value || "")
                .toLowerCase()
                .trim()
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .replace(/&/g, " and ")
                .replace(/[^a-z0-9]+/g, "-")
                .replace(/^-+|-+$/g, "");
        }


        /*
        |--------------------------------------------------------------------------
        | Detect whether admin manually edited slug
        |--------------------------------------------------------------------------
        */

        let slugWasManuallyEdited =
            productSlug.value.trim() !== "";

        let generatedSlug =
            productSlug.value.trim();


        productSlug.addEventListener("input", function () {
            const currentValue =
                productSlug.value.trim();

            /*
            | If admin changes the automatically generated value,
            | stop automatically replacing it.
            */

            slugWasManuallyEdited =
                currentValue !== generatedSlug;

            updateUrlPreview();
        });


        productSlug.addEventListener("blur", function () {
            const cleaned =
                slugify(productSlug.value);

            productSlug.value = cleaned;

            generatedSlug = cleaned;

            updateUrlPreview();
        });


        /*
        |--------------------------------------------------------------------------
        | Auto-generate slug from Product Name
        |--------------------------------------------------------------------------
        */

        if (productName) {
            productName.addEventListener(
                "input",
                function () {
                    if (
                        slugWasManuallyEdited &&
                        productSlug.value.trim() !== ""
                    ) {
                        updateUrlPreview();
                        return;
                    }

                    generatedSlug =
                        slugify(productName.value);

                    productSlug.value =
                        generatedSlug;

                    updateUrlPreview();
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Category changes public URL
        |--------------------------------------------------------------------------
        */

        productCategory?.addEventListener(
            "input",
            updateUrlPreview
        );

        productCategory?.addEventListener(
            "change",
            updateUrlPreview
        );

        /*
        |--------------------------------------------------------------------------
        | Custom Category Dropdown
        |--------------------------------------------------------------------------
        | The custom select changes the hidden category input directly.
        | Watch that value so the URL preview updates immediately.
        |--------------------------------------------------------------------------
        */

        let lastCategoryValue =
            productCategory?.value || "";

        if (productCategory) {
            window.setInterval(function () {

                const currentCategoryValue =
                    productCategory.value || "";

                if (
                    currentCategoryValue !==
                    lastCategoryValue
                ) {
                    lastCategoryValue =
                        currentCategoryValue;

                    updateUrlPreview();
                }

            }, 100);
        }


        /*
        |--------------------------------------------------------------------------
        | Product URL Preview
        |--------------------------------------------------------------------------
        */

        function updateUrlPreview() {
            if (!productUrlPreview) {
                return;
            }

            const category =
                slugify(
                    productCategory?.value || ""
                );

            const slug =
                slugify(productSlug.value) ||
                "product-slug";

            productUrlPreview.textContent =
                category
                    ? `/${category}/${slug}`
                    : `/category/${slug}`;
        }


        updateUrlPreview();
    }


    /*
    |--------------------------------------------------------------------------
    | FEATURED IMAGE PREVIEW
    |--------------------------------------------------------------------------
    */

    function initialiseFeaturedImage() {
        const input =
            document.getElementById(
                "featuredImageInput"
            );

        const preview =
            document.getElementById(
                "featuredPreview"
            );

        if (!input || !preview) {
            return;
        }


        input.addEventListener(
            "change",
            function () {
                const file =
                    input.files?.[0];

                if (!file) {
                    return;
                }

                if (!isValidImage(file)) {
                    input.value = "";

                    alert(
                        "Please select a valid JPG, JPEG, PNG or WEBP image."
                    );

                    return;
                }

                renderImagePreview(
                    file,
                    preview,
                    "ml-featured-preview",
                    "Featured product image preview"
                );
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | OPEN GRAPH IMAGE PREVIEW
    |--------------------------------------------------------------------------
    */

    function initialiseOgImage() {
        const input =
            document.getElementById(
                "ogImageInput"
            );

        const preview =
            document.getElementById(
                "ogImagePreview"
            );

        if (!input || !preview) {
            return;
        }


        input.addEventListener(
            "change",
            function () {
                const file =
                    input.files?.[0];

                preview.innerHTML = "";

                if (!file) {
                    return;
                }

                if (!isValidImage(file)) {
                    input.value = "";

                    alert(
                        "Please select a valid JPG, JPEG, PNG or WEBP image."
                    );

                    return;
                }

                renderImagePreview(
                    file,
                    preview,
                    "ml-og-preview-image",
                    "Social sharing image preview"
                );
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PRODUCT GALLERY MANAGER
    |--------------------------------------------------------------------------
    |
    | Supports:
    |
    | + Add image one-by-one
    | + Image preview
    | + Image Name
    | + ALT Text
    | + Replace existing image
    | + Remove image
    | + Automatic field indexing
    | + Automatic sort order
    |
    */

    function initialiseGalleryManager() {
        const galleryList =
            document.getElementById(
                "galleryItemList"
            );

        const addButton =
            document.getElementById(
                "addGalleryImageBtn"
            );

        const template =
            document.getElementById(
                "galleryItemTemplate"
            );

        const emptyState =
            document.getElementById(
                "galleryEmptyState"
            );

        if (
            !galleryList ||
            !addButton ||
            !template
        ) {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Existing rows
        |--------------------------------------------------------------------------
        */

        getGalleryRows().forEach(
            bindGalleryRow
        );

        updateGalleryRows();


        /*
        |--------------------------------------------------------------------------
        | Add New Image
        |--------------------------------------------------------------------------
        */

        addButton.addEventListener(
            "click",
            function () {
                const fragment =
                    template.content.cloneNode(true);

                const newRow =
                    fragment.querySelector(
                        "[data-gallery-row]"
                    );

                if (!newRow) {
                    return;
                }

                galleryList.appendChild(
                    fragment
                );

                bindGalleryRow(newRow);

                updateGalleryRows();


                /*
                | Focus file chooser input area
                */

                const fileInput =
                    newRow.querySelector(
                        "[data-gallery-image]"
                    );

                if (fileInput) {
                    window.setTimeout(
                        function () {
                            fileInput.click();
                        },
                        50
                    );
                }
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Get Gallery Rows
        |--------------------------------------------------------------------------
        */

        function getGalleryRows() {
            return Array.from(
                galleryList.querySelectorAll(
                    "[data-gallery-row]"
                )
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Bind Row
        |--------------------------------------------------------------------------
        */

        function bindGalleryRow(row) {
            if (
                row.dataset.galleryBound ===
                "true"
            ) {
                return;
            }

            row.dataset.galleryBound =
                "true";


            const imageInput =
                row.querySelector(
                    "[data-gallery-image]"
                );

            const preview =
                row.querySelector(
                    "[data-gallery-preview]"
                );

            const removeButton =
                row.querySelector(
                    "[data-remove-gallery]"
                );


            /*
            |--------------------------------------------------------------------------
            | Image Preview
            |--------------------------------------------------------------------------
            */

            imageInput?.addEventListener(
                "change",
                function () {
                    const file =
                        imageInput.files?.[0];

                    if (!file) {
                        return;
                    }

                    if (!isValidImage(file)) {
                        imageInput.value = "";

                        alert(
                            "Please select a valid JPG, JPEG, PNG or WEBP image."
                        );

                        return;
                    }

                    if (preview) {
                        renderImagePreview(
                            file,
                            preview,
                            "",
                            "Product gallery image preview"
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Auto-fill Image Name
                    |--------------------------------------------------------------------------
                    |
                    | Example:
                    | mighty-plus-front-view.webp
                    |
                    | becomes:
                    | Mighty Plus Front View
                    |
                    */

                    const imageNameInput =
                        row.querySelector(
                            '[data-gallery-field="image_name"]'
                        );

                    if (
                        imageNameInput &&
                        !imageNameInput.value.trim()
                    ) {
                        imageNameInput.value =
                            humaniseFilename(
                                file.name
                            );
                    }
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Remove Gallery Image
            |--------------------------------------------------------------------------
            */

            removeButton?.addEventListener(
                "click",
                function () {
                    const imageName =
                        row.querySelector(
                            '[data-gallery-field="image_name"]'
                        )?.value?.trim();

                    const existingId =
                        row.querySelector(
                            '[data-gallery-field="id"]'
                        )?.value;


                    /*
                    | Existing database image:
                    | ask for confirmation.
                    */

                    if (existingId) {
                        const confirmed =
                            window.confirm(
                                imageName
                                    ? `Remove "${imageName}" from the product gallery?`
                                    : "Remove this image from the product gallery?"
                            );

                        if (!confirmed) {
                            return;
                        }
                    }

                    row.remove();

                    updateGalleryRows();
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Re-index Gallery
        |--------------------------------------------------------------------------
        */

        function updateGalleryRows() {
            const rows =
                getGalleryRows();


            rows.forEach(
                function (row, index) {
                    /*
                    |--------------------------------------------------------------------------
                    | Heading
                    |--------------------------------------------------------------------------
                    */

                    const number =
                        row.querySelector(
                            "[data-gallery-number]"
                        );

                    if (number) {
                        number.textContent =
                            `Image ${index + 1}`;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Existing ID
                    |--------------------------------------------------------------------------
                    */

                    const idInput =
                        row.querySelector(
                            '[data-gallery-field="id"]'
                        );

                    if (idInput) {
                        idInput.name =
                            `gallery_items[${index}][id]`;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | File Input
                    |--------------------------------------------------------------------------
                    */

                    const imageInput =
                        row.querySelector(
                            '[data-gallery-field="image"]'
                        ) ||
                        row.querySelector(
                            "[data-gallery-image]"
                        );

                    if (imageInput) {
                        imageInput.name =
                            `gallery_items[${index}][image]`;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Image Name
                    |--------------------------------------------------------------------------
                    */

                    const imageName =
                        row.querySelector(
                            '[data-gallery-field="image_name"]'
                        );

                    if (imageName) {
                        imageName.name =
                            `gallery_items[${index}][image_name]`;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | ALT Text
                    |--------------------------------------------------------------------------
                    */

                    const altText =
                        row.querySelector(
                            '[data-gallery-field="alt_text"]'
                        );

                    if (altText) {
                        altText.name =
                            `gallery_items[${index}][alt_text]`;
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Sort Order
                    |--------------------------------------------------------------------------
                    */

                    const sortOrder =
                        row.querySelector(
                            '[data-gallery-field="sort_order"]'
                        );

                    if (sortOrder) {
                        sortOrder.name =
                            `gallery_items[${index}][sort_order]`;

                        sortOrder.value =
                            String(index);
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Remove Marker
                    |--------------------------------------------------------------------------
                    */

                    const removeInput =
                        row.querySelector(
                            "[data-gallery-remove]"
                        );

                    if (removeInput) {
                        removeInput.name =
                            `gallery_items[${index}][remove]`;

                        removeInput.value = "0";
                    }
                }
            );


            /*
            |--------------------------------------------------------------------------
            | Empty state
            |--------------------------------------------------------------------------
            */

            if (emptyState) {
                emptyState.classList.toggle(
                    "d-none",
                    rows.length > 0
                );
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | IMAGE VALIDATION
    |--------------------------------------------------------------------------
    */

    function isValidImage(file) {
        if (!file) {
            return false;
        }

        const allowedTypes = [
            "image/jpeg",
            "image/png",
            "image/webp",
        ];

        if (
            !allowedTypes.includes(file.type)
        ) {
            return false;
        }


        /*
        | 5 MB limit
        */

        const maxSize =
            5 * 1024 * 1024;

        if (file.size > maxSize) {
            alert(
                "Image size must not exceed 5MB."
            );

            return false;
        }

        return true;
    }


    /*
    |--------------------------------------------------------------------------
    | IMAGE PREVIEW
    |--------------------------------------------------------------------------
    */

    function renderImagePreview(
        file,
        container,
        className = "",
        altText = "Image preview"
    ) {
        if (!file || !container) {
            return;
        }

        const reader =
            new FileReader();


        reader.addEventListener(
            "load",
            function (event) {
                const imageUrl =
                    event.target?.result;

                if (
                    typeof imageUrl !== "string"
                ) {
                    return;
                }

                const image =
                    document.createElement(
                        "img"
                    );

                image.src = imageUrl;
                image.alt = altText;

                if (className) {
                    image.className =
                        className;
                }

                container.innerHTML = "";

                container.appendChild(
                    image
                );
            }
        );


        reader.readAsDataURL(file);
    }


    /*
    |--------------------------------------------------------------------------
    | HUMANISE FILENAME
    |--------------------------------------------------------------------------
    */

    function humaniseFilename(filename) {
        return String(filename || "")
            .replace(/\.[^/.]+$/, "")
            .replace(/[_-]+/g, " ")
            .replace(/\s+/g, " ")
            .trim()
            .replace(
                /\b\w/g,
                function (character) {
                    return character.toUpperCase();
                }
            );
    }
});

/* =========================================================
   MEDILEAF CUSTOM SELECT
   ========================================================= */

document.addEventListener('DOMContentLoaded', function () {

    const customSelects = document.querySelectorAll('.ml-custom-select');

    customSelects.forEach(function (select) {

        const button = select.querySelector('.ml-custom-select-btn');
        const valueDisplay = select.querySelector('.ml-custom-select-value');
        const hiddenInput = select.querySelector('input[type="hidden"]');
        const options = select.querySelectorAll('.ml-custom-option');

        if (!button || !valueDisplay || !hiddenInput) {
            return;
        }


        /* Existing value */
        if (hiddenInput.value) {

            const selectedOption = select.querySelector(
                '.ml-custom-option[data-value="' +
                CSS.escape(hiddenInput.value) +
                '"]'
            );

            if (selectedOption) {

                valueDisplay.textContent =
                    selectedOption.textContent.trim();

                selectedOption.classList.add('selected');
            }
        }


        /* Open dropdown */
        button.addEventListener('click', function (event) {

            event.preventDefault();
            event.stopPropagation();

            /* Close other dropdowns */
            customSelects.forEach(function (otherSelect) {

                if (otherSelect !== select) {
                    otherSelect.classList.remove('open');
                }

            });

            select.classList.toggle('open');
        });


        /* Select option */
        options.forEach(function (option) {

            option.addEventListener('click', function (event) {

                event.preventDefault();
                event.stopPropagation();

                const value = this.getAttribute('data-value');
                const text = this.textContent.trim();

                /* Set actual form value */
                hiddenInput.value = value;

                /* Change visible text */
                valueDisplay.textContent = text;

                /* Remove old selected state */
                options.forEach(function (item) {
                    item.classList.remove('selected');
                });

                /* Add selected state */
                this.classList.add('selected');

                /* Close */
                select.classList.remove('open');
            });

        });

    });


    /* Close when clicking outside */

    document.addEventListener('click', function (event) {

        customSelects.forEach(function (select) {

            if (!select.contains(event.target)) {
                select.classList.remove('open');
            }

        });

    });

});