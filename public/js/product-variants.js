document.addEventListener("DOMContentLoaded", function () {
    "use strict";

    initialiseEditor();
    initialiseProductVariants();

    function initialiseEditor() {
        const descriptionField = document.getElementById("description");

        if (!descriptionField) {
            return;
        }

        if (typeof window.ClassicEditor === "undefined") {
            console.error("CKEditor library did not load.");
            return;
        }

        window.ClassicEditor
            .create(descriptionField)
            .catch(function (error) {
                console.error("CKEditor error:", error);
            });
    }

    function initialiseProductVariants() {
        const variantList = document.getElementById("variantList");
        const addVariantButton = document.getElementById("addVariantBtn");
        const variantTemplate = document.getElementById("variantTemplate");

        if (!variantList || !addVariantButton || !variantTemplate) {
            return;
        }

        const variantCount = document.getElementById("variantCount");
        const variantTotalStock = document.getElementById("variantTotalStock");
        const stockQuantity = document.getElementById("stockQuantity");
        const lowStockAlert = document.getElementById("lowStockAlert");
        const stockStatus = document.getElementById("stockStatus");
        const stockStatusDisplay = document.getElementById("stockStatusDisplay");

        function getRows() {
            return Array.from(
                variantList.querySelectorAll("[data-variant-row]")
            );
        }

        function updateVariantNames(row, index) {
            const variantNumber = row.querySelector(".ml-variant-number");

            if (variantNumber) {
                variantNumber.textContent = String(index + 1);
            }

            row.querySelectorAll("[data-field]").forEach(function (field) {
                const fieldName = field.dataset.field;

                if (fieldName) {
                    field.name = `variants[${index}][${fieldName}]`;
                }
            });

            row.querySelectorAll(
                'input[name^="variants["], select[name^="variants["]'
            ).forEach(function (field) {
                const match = field.name.match(/\]\[([^\]]+)\]$/);

                if (match) {
                    field.name = `variants[${index}][${match[1]}]`;
                }
            });
        }

        function updateSummary() {
            const rows = getRows();
            let totalStock = 0;

            rows.forEach(function (row, index) {
                updateVariantNames(row, index);

                const quantityInput = row.querySelector(
                    ".ml-variant-quantity"
                );

                totalStock += Math.max(
                    0,
                    Number(quantityInput?.value || 0)
                );
            });

            if (variantCount) {
                variantCount.textContent = String(rows.length);
            }

            if (variantTotalStock) {
                variantTotalStock.textContent = String(totalStock);
            }

            if (stockQuantity) {
                stockQuantity.value = String(totalStock);
            }

            const alertLevel = Math.max(
                0,
                Number(lowStockAlert?.value || 0)
            );

            let statusValue = "in_stock";
            let statusLabel = "In Stock";

            if (totalStock <= 0) {
                statusValue = "out_of_stock";
                statusLabel = "Out of Stock";
            } else if (totalStock <= alertLevel) {
                statusValue = "low_stock";
                statusLabel = "Low Stock";
            }

            if (stockStatus) {
                stockStatus.value = statusValue;
            }

            if (stockStatusDisplay) {
                stockStatusDisplay.textContent = statusLabel;
                stockStatusDisplay.className =
                    `ml-auto-stock-status ${statusValue}`;
            }

            rows.forEach(function (row) {
                const removeButton = row.querySelector(
                    "[data-remove-variant]"
                );

                if (removeButton) {
                    removeButton.disabled = rows.length <= 1;
                }
            });
        }

        function bindColourInputs(row) {
            const picker = row.querySelector("[data-colour-picker]");
            const codeInput = row.querySelector("[data-colour-code]");

            if (!picker || !codeInput) {
                return;
            }

            picker.addEventListener("input", function () {
                codeInput.value = picker.value.toUpperCase();
            });

            codeInput.addEventListener("input", function () {
                const value = codeInput.value.trim();

                if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                    picker.value = value;
                }
            });
        }

        function bindImagePreview(row) {
            const imageInput = row.querySelector("[data-variant-image]");
            const preview = row.querySelector("[data-variant-preview]");

            if (!imageInput || !preview) {
                return;
            }

            imageInput.addEventListener("change", function () {
                const file = imageInput.files?.[0];

                preview.innerHTML = "";

                if (!file) {
                    return;
                }

                if (!file.type.startsWith("image/")) {
                    imageInput.value = "";
                    alert("Please select a valid image file.");
                    return;
                }

                const reader = new FileReader();

                reader.addEventListener("load", function (event) {
                    const imageUrl = event.target?.result;

                    if (typeof imageUrl !== "string") {
                        return;
                    }

                    const image = document.createElement("img");
                    image.src = imageUrl;
                    image.alt = "Variant image preview";

                    preview.appendChild(image);
                });

                reader.readAsDataURL(file);
            });
        }

        function bindRow(row) {
            if (row.dataset.bound === "true") {
                return;
            }

            row.dataset.bound = "true";

            const removeButton = row.querySelector(
                "[data-remove-variant]"
            );

            if (removeButton) {
                removeButton.addEventListener("click", function () {
                    if (getRows().length <= 1) {
                        return;
                    }

                    row.remove();
                    updateSummary();
                });
            }

            const quantityInput = row.querySelector(
                ".ml-variant-quantity"
            );

            if (quantityInput) {
                quantityInput.addEventListener("input", updateSummary);
            }

            bindColourInputs(row);
            bindImagePreview(row);
        }

        addVariantButton.addEventListener("click", function () {
            const fragment = variantTemplate.content.cloneNode(true);
            const newRow = fragment.querySelector("[data-variant-row]");

            if (!newRow) {
                return;
            }

            variantList.appendChild(fragment);
            bindRow(newRow);
            updateSummary();

            newRow
                .querySelector('[data-field="colour_name"]')
                ?.focus();
        });

        getRows().forEach(bindRow);

        lowStockAlert?.addEventListener("input", updateSummary);

        updateSummary();
    }
});
