"use strict";

/*
|--------------------------------------------------------------------------
| MediLeaf Admin Product
|--------------------------------------------------------------------------
|
| Handles:
| - CKEditor for Full Description only
| - Product colour variants
| - Stock calculations
| - Colour picker sync
| - Variant image previews
|
*/


/*
|--------------------------------------------------------------------------
| Boot
|--------------------------------------------------------------------------
*/

function bootMediLeafProductAdmin() {
    initialiseEditor();
    initialiseProductVariants();
    initialiseProductUrlPreview();
}


/*
|--------------------------------------------------------------------------
| Safe Page Load
|--------------------------------------------------------------------------
|
| This fixes the live issue where the script may load after
| DOMContentLoaded has already fired.
|
*/

if (document.readyState === "loading") {
    document.addEventListener(
        "DOMContentLoaded",
        bootMediLeafProductAdmin
    );
} else {
    bootMediLeafProductAdmin();
}


/*
|--------------------------------------------------------------------------
| CKEditor
|--------------------------------------------------------------------------
|
| CKEditor is applied ONLY to:
|
| #description
|
| Short Description, Meta Description and OG Description remain
| normal textareas.
|
*/

function initialiseEditor() {
    const descriptionField =
        document.getElementById("description");

    if (!descriptionField) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Prevent Duplicate Editor
    |--------------------------------------------------------------------------
    */

    if (
        descriptionField.dataset.editorInitialised ===
        "true"
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Check CKEditor Library
    |--------------------------------------------------------------------------
    */

    if (
        typeof window.ClassicEditor ===
        "undefined"
    ) {
        console.error(
            "CKEditor library did not load."
        );

        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Initialise Editor
    |--------------------------------------------------------------------------
    */

    descriptionField.dataset.editorInitialised =
        "true";

    window.ClassicEditor
        .create(descriptionField)
        .then(function (editor) {
            window.mlProductDescriptionEditor =
                editor;
        })
        .catch(function (error) {
            descriptionField.dataset.editorInitialised =
                "false";

            console.error(
                "CKEditor initialisation error:",
                error
            );
        });
}


/*
|--------------------------------------------------------------------------
| Product URL Preview
|--------------------------------------------------------------------------
|
| Updates the admin Product URL immediately when:
| - Category changes
| - Product name changes
| - Slug changes
|
| Example:
| Vaporisers + Volcano Hybrid Vaporise
| -> /vaporisers/volcano-hybrid-vaporise
|
*/

function initialiseProductUrlPreview() {
    const categoryField =
        document.getElementById("productCategory");

    const nameField =
        document.getElementById("productName");

    const slugField =
        document.getElementById("productSlug");

    const urlPreview =
        document.getElementById("productUrlPreview");


    if (
        !categoryField ||
        !slugField ||
        !urlPreview
    ) {
        return;
    }


    function makeSlug(value) {
        return String(value || "")
            .trim()
            .toLowerCase()
            .replace(/&/g, " and ")
            .replace(/[^a-z0-9]+/g, "-")
            .replace(/^-+|-+$/g, "");
    }


    function updateUrlPreview() {
        const category =
            makeSlug(categoryField.value);

        let productSlug =
            slugField.value.trim();

        /*
        | If slug is empty, use the product name
        | for the preview only.
        */
        if (!productSlug && nameField) {
            productSlug =
                makeSlug(nameField.value);
        } else {
            productSlug =
                makeSlug(productSlug);
        }


        /*
        |--------------------------------------------------------------------------
        | Do not show "uncategorised" when a category
        | has been selected.
        |--------------------------------------------------------------------------
        */

        if (!category) {
            urlPreview.textContent =
                productSlug
                    ? `/uncategorised/${productSlug}`
                    : "/uncategorised/product";
            return;
        }


        urlPreview.textContent =
            productSlug
                ? `/${category}/${productSlug}`
                : `/${category}/product`;
    }


    categoryField.addEventListener(
        "change",
        updateUrlPreview
    );


    slugField.addEventListener(
        "input",
        updateUrlPreview
    );


    nameField?.addEventListener(
        "input",
        updateUrlPreview
    );


    /*
    |--------------------------------------------------------------------------
    | Initial Preview
    |--------------------------------------------------------------------------
    */

    updateUrlPreview();
}


/*
|--------------------------------------------------------------------------
| Product Variants
|--------------------------------------------------------------------------
*/

function initialiseProductVariants() {
    const variantList =
        document.getElementById("variantList");

    const addVariantButton =
        document.getElementById("addVariantBtn");

    const variantTemplate =
        document.getElementById("variantTemplate");


    if (
        !variantList ||
        !addVariantButton ||
        !variantTemplate
    ) {
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Prevent Duplicate Variant Initialisation
    |--------------------------------------------------------------------------
    */

    if (
        variantList.dataset.initialised ===
        "true"
    ) {
        return;
    }

    variantList.dataset.initialised =
        "true";


    const variantCount =
        document.getElementById("variantCount");

    const variantTotalStock =
        document.getElementById(
            "variantTotalStock"
        );

    const stockQuantity =
        document.getElementById(
            "stockQuantity"
        );

    const lowStockAlert =
        document.getElementById(
            "lowStockAlert"
        );

    const stockStatus =
        document.getElementById(
            "stockStatus"
        );

    const stockStatusDisplay =
        document.getElementById(
            "stockStatusDisplay"
        );


    /*
    |--------------------------------------------------------------------------
    | Get Variant Rows
    |--------------------------------------------------------------------------
    */

    function getRows() {
        return Array.from(
            variantList.querySelectorAll(
                "[data-variant-row]"
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Variant Field Names
    |--------------------------------------------------------------------------
    */

    function updateVariantNames(
        row,
        index
    ) {
        const variantNumber =
            row.querySelector(
                ".ml-variant-number"
            );


        if (variantNumber) {
            variantNumber.textContent =
                String(index + 1);
        }


        /*
        |--------------------------------------------------------------------------
        | New Template Fields
        |--------------------------------------------------------------------------
        */

        row.querySelectorAll(
            "[data-field]"
        ).forEach(function (field) {
            const fieldName =
                field.dataset.field;

            if (!fieldName) {
                return;
            }

            field.name =
                `variants[${index}][${fieldName}]`;
        });


        /*
        |--------------------------------------------------------------------------
        | Existing Blade Fields
        |--------------------------------------------------------------------------
        */

        row.querySelectorAll(
            'input[name^="variants["], select[name^="variants["]'
        ).forEach(function (field) {
            const match =
                field.name.match(
                    /\]\[([^\]]+)\]$/
                );

            if (!match) {
                return;
            }

            field.name =
                `variants[${index}][${match[1]}]`;
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Update Stock Summary
    |--------------------------------------------------------------------------
    */

    function updateSummary() {
        const rows =
            getRows();

        let totalStock = 0;

        if (rows.length === 0) {
            if (variantCount) {
                variantCount.textContent = "0";
            }

            if (variantTotalStock) {
                variantTotalStock.textContent = "0";
            }

            return;
        }


        rows.forEach(
            function (row, index) {
                updateVariantNames(
                    row,
                    index
                );


                const quantityInput =
                    row.querySelector(
                        ".ml-variant-quantity"
                    );


                totalStock += Math.max(
                    0,
                    Number(
                        quantityInput?.value ||
                        0
                    )
                );
            }
        );


        /*
        |--------------------------------------------------------------------------
        | Variant Count
        |--------------------------------------------------------------------------
        */

        if (variantCount) {
            variantCount.textContent =
                String(rows.length);
        }


        /*
        |--------------------------------------------------------------------------
        | Total Stock
        |--------------------------------------------------------------------------
        */

        if (variantTotalStock) {
            variantTotalStock.textContent =
                String(totalStock);
        }


        if (stockQuantity && rows.length > 0) {
            stockQuantity.value =
                String(totalStock);
        }


        /*
        |--------------------------------------------------------------------------
        | Low Stock Level
        |--------------------------------------------------------------------------
        */

        const alertLevel =
            Math.max(
                0,
                Number(
                    lowStockAlert?.value ||
                    0
                )
            );


        /*
        |--------------------------------------------------------------------------
        | Stock Status
        |--------------------------------------------------------------------------
        */

        let statusValue =
            "in_stock";

        let statusLabel =
            "In Stock";


        if (totalStock <= 0) {
            statusValue =
                "out_of_stock";

            statusLabel =
                "Out of Stock";
        } else if (
            totalStock <= alertLevel
        ) {
            statusValue =
                "low_stock";

            statusLabel =
                "Low Stock";
        }


        if (stockStatus) {
            stockStatus.value =
                statusValue;
        }


        if (stockStatusDisplay) {
            stockStatusDisplay.textContent =
                statusLabel;

            stockStatusDisplay.className =
                `ml-auto-stock-status ${statusValue}`;
        }


        /*
        |--------------------------------------------------------------------------
        | Remove Button State
        |--------------------------------------------------------------------------
        */

        rows.forEach(function (row) {
            const removeButton =
                row.querySelector(
                    "[data-remove-variant]"
                );

            if (removeButton) {
                removeButton.disabled = false;
            }
        });
    }


    /*
    |--------------------------------------------------------------------------
    | Colour Picker
    |--------------------------------------------------------------------------
    */

    function bindColourInputs(row) {
        const picker =
            row.querySelector(
                "[data-colour-picker]"
            );

        const codeInput =
            row.querySelector(
                "[data-colour-code]"
            );


        if (
            !picker ||
            !codeInput
        ) {
            return;
        }


        picker.addEventListener(
            "input",
            function () {
                codeInput.value =
                    picker.value.toUpperCase();
            }
        );


        codeInput.addEventListener(
            "input",
            function () {
                const value =
                    codeInput.value.trim();


                if (
                    /^#[0-9A-Fa-f]{6}$/.test(
                        value
                    )
                ) {
                    picker.value =
                        value;
                }
            }
        );


        codeInput.addEventListener(
            "blur",
            function () {
                let value =
                    codeInput.value.trim();


                if (!value) {
                    return;
                }


                /*
                | Allow user to enter:
                |
                | 31A050
                |
                | and convert it to:
                |
                | #31A050
                */

                if (
                    /^[0-9A-Fa-f]{6}$/.test(
                        value
                    )
                ) {
                    value =
                        `#${value}`;
                }


                if (
                    /^#[0-9A-Fa-f]{6}$/.test(
                        value
                    )
                ) {
                    value =
                        value.toUpperCase();

                    codeInput.value =
                        value;

                    picker.value =
                        value;
                }
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Variant Image Preview
    |--------------------------------------------------------------------------
    */

    function bindImagePreview(row) {
        const imageInput =
            row.querySelector(
                "[data-variant-image]"
            );

        const preview =
            row.querySelector(
                "[data-variant-preview]"
            );


        if (
            !imageInput ||
            !preview
        ) {
            return;
        }


        imageInput.addEventListener(
            "change",
            function () {
                const file =
                    imageInput.files?.[0];


                preview.innerHTML =
                    "";


                if (!file) {
                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Allowed Image Types
                |--------------------------------------------------------------------------
                */

                const allowedTypes = [
                    "image/jpeg",
                    "image/png",
                    "image/webp",
                ];


                if (
                    !allowedTypes.includes(
                        file.type
                    )
                ) {
                    imageInput.value =
                        "";

                    alert(
                        "Please select a valid JPG, JPEG, PNG or WEBP image."
                    );

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Maximum 5 MB
                |--------------------------------------------------------------------------
                */

                const maxSize =
                    5 * 1024 * 1024;


                if (
                    file.size >
                    maxSize
                ) {
                    imageInput.value =
                        "";

                    alert(
                        "Variant image size must not exceed 5MB."
                    );

                    return;
                }


                /*
                |--------------------------------------------------------------------------
                | Preview
                |--------------------------------------------------------------------------
                */

                const reader =
                    new FileReader();


                reader.addEventListener(
                    "load",
                    function (event) {
                        const imageUrl =
                            event.target
                                ?.result;


                        if (
                            typeof imageUrl !==
                            "string"
                        ) {
                            return;
                        }


                        const image =
                            document.createElement(
                                "img"
                            );


                        image.src =
                            imageUrl;

                        image.alt =
                            "Variant image preview";


                        preview.appendChild(
                            image
                        );
                    }
                );


                reader.readAsDataURL(
                    file
                );
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Bind Variant Row
    |--------------------------------------------------------------------------
    */

    function bindRow(row) {
        if (
            row.dataset.bound ===
            "true"
        ) {
            return;
        }


        row.dataset.bound =
            "true";


        /*
        |--------------------------------------------------------------------------
        | Remove Variant
        |--------------------------------------------------------------------------
        */

        const removeButton =
            row.querySelector(
                "[data-remove-variant]"
            );


        if (removeButton) {
            removeButton.addEventListener(
                "click",
                function () {
                    const colourName =
                        row.querySelector(
                            'input[name*="[colour_name]"], [data-field="colour_name"]'
                        )
                            ?.value
                            ?.trim();


                    const confirmed =
                        window.confirm(
                            colourName
                                ? `Remove "${colourName}" colour variant?`
                                : "Remove this colour variant?"
                        );


                    if (!confirmed) {
                        return;
                    }


                    row.remove();

                    updateSummary();
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Quantity
        |--------------------------------------------------------------------------
        */

        const quantityInput =
            row.querySelector(
                ".ml-variant-quantity"
            );


        if (quantityInput) {
            quantityInput.addEventListener(
                "input",
                updateSummary
            );
        }


        bindColourInputs(row);

        bindImagePreview(row);
    }


    /*
    |--------------------------------------------------------------------------
    | Add New Variant
    |--------------------------------------------------------------------------
    */

    addVariantButton.addEventListener(
        "click",
        function () {
            const fragment =
                variantTemplate
                    .content
                    .cloneNode(true);


            const newRow =
                fragment.querySelector(
                    "[data-variant-row]"
                );


            if (!newRow) {
                return;
            }


            variantList.appendChild(
                fragment
            );


            bindRow(newRow);

            updateSummary();


            /*
            |--------------------------------------------------------------------------
            | Focus New Colour Name
            |--------------------------------------------------------------------------
            */

            newRow
                .querySelector(
                    '[data-field="colour_name"]'
                )
                ?.focus();
        }
    );


    /*
    |--------------------------------------------------------------------------
    | Existing Rows
    |--------------------------------------------------------------------------
    */

    getRows().forEach(
        bindRow
    );


    /*
    |--------------------------------------------------------------------------
    | Low Stock Input
    |--------------------------------------------------------------------------
    */

    lowStockAlert?.addEventListener(
        "input",
        updateSummary
    );


    /*
    |--------------------------------------------------------------------------
    | Initial Calculation
    |--------------------------------------------------------------------------
    */

    updateSummary();
}