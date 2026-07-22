const uploadBox = document.getElementById("uploadBox");
const fileInput = document.getElementById("prescriptionFile");
const fileName = document.getElementById("fileName");

if (uploadBox && fileInput && fileName) {

    // Click Upload
    uploadBox.addEventListener("click", () => {
        fileInput.click();
    });

    // File Selected
    fileInput.addEventListener("change", function () {

        if (this.files.length > 0) {

            const file = this.files[0];

            if (file.size > 5 * 1024 * 1024) {
                alert("Maximum file size is 5MB.");
                this.value = "";
                fileName.innerHTML = "";
                return;
            }

            fileName.innerHTML = "📄 " + file.name;
        }

    });

    // Drag Over
    uploadBox.addEventListener("dragover", function (e) {
        e.preventDefault();
        uploadBox.classList.add("dragover");
    });

    // Drag Leave
    uploadBox.addEventListener("dragleave", function () {
        uploadBox.classList.remove("dragover");
    });

    // Drop File
    uploadBox.addEventListener("drop", function (e) {

        e.preventDefault();
        uploadBox.classList.remove("dragover");

        const files = e.dataTransfer.files;

        if (files.length) {

            fileInput.files = files;

            if (files[0].size > 5 * 1024 * 1024) {
                alert("Maximum file size is 5MB.");
                fileInput.value = "";
                fileName.innerHTML = "";
                return;
            }

            fileName.innerHTML = "📄 " + files[0].name;
        }

    });

}

/* =============submitpopup========================== */

function closeSuccessPopup() {
    const popup = document.getElementById("successPopup");

    if (popup) {
        popup.style.display = "none";
    }
}