document.addEventListener("DOMContentLoaded", function () {

    /*===========================
      Mobile Sidebar
    ===========================*/

    const menuBtn = document.getElementById("mlAdminMenuToggle");
    const sidebar = document.querySelector(".ml-admin-sidebar");

    if (menuBtn && sidebar) {

        menuBtn.addEventListener("click", function () {

            sidebar.classList.toggle("show");

        });

    }

});

// ===========================

document.addEventListener("DOMContentLoaded", function () {

    /*===========================
      Mobile Sidebar
    ===========================*/
    const menuBtn = document.getElementById("mlAdminMenuToggle");
    const sidebar = document.querySelector(".ml-admin-sidebar");

    if (menuBtn && sidebar) {
        menuBtn.addEventListener("click", function () {
            sidebar.classList.toggle("show");
        });
    }


    /*===========================
      Auto Slug
    ===========================*/
    const productName = document.getElementById("productName");
    const productSlug = document.getElementById("productSlug");

    if (productName && productSlug) {
        productName.addEventListener("keyup", function () {
            productSlug.value = this.value
                .toLowerCase()
                .trim()
                .replace(/[^a-z0-9]+/g, "-")
                .replace(/^-+|-+$/g, "");
        });
    }


    /*===========================
      Featured Image Preview
    ===========================*/
    const featuredInput = document.getElementById("featuredImageInput");
    const featuredPreview = document.getElementById("featuredPreview");

    if (featuredInput && featuredPreview) {
        featuredInput.addEventListener("change", function () {
            const file = this.files[0];

            if (!file) return;

            if (!file.type.startsWith("image/")) {
                alert("Please select a valid image.");
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {
                featuredPreview.innerHTML = `
                    <img src="${e.target.result}" class="ml-featured-preview">
                `;
            };

            reader.readAsDataURL(file);
        });
    }


    /*===========================
      Gallery Preview
    ===========================*/
    const galleryInput = document.getElementById("galleryInput");
    const galleryPreview = document.getElementById("galleryPreview");

    if (galleryInput && galleryPreview) {
        galleryInput.addEventListener("change", function () {
            galleryPreview.innerHTML = "";

            Array.from(this.files).forEach(function (file) {
                if (!file.type.startsWith("image/")) return;

                const reader = new FileReader();

                reader.onload = function (e) {
                    galleryPreview.innerHTML += `
                        <div class="ml-gallery-item">
                            <img src="${e.target.result}">
                        </div>
                    `;
                };

                reader.readAsDataURL(file);
            });
        });
    }

});

// /* Admin Success Message */
// const successAlert = document.getElementById("mlAdminSuccessAlert");
// const successClose = document.getElementById("mlAdminSuccessClose");

// if (successAlert) {
//     if (successClose) {
//         successClose.addEventListener("click", function () {
//             successAlert.classList.add("hide");

//             setTimeout(function () {
//                 successAlert.remove();
//             }, 300);
//         });
//     }

//     setTimeout(function () {
//         successAlert.classList.add("hide");

//         setTimeout(function () {
//             successAlert.remove();
//         }, 300);
//     }, 4000);
// }