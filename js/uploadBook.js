const uploadBookForm = document.getElementById("uploadBookForm");
const profileImage = document.getElementById("profileImageBase64");
const imagePreview = document.querySelector(".add-book-image img, .edit-image img");
const fileInput = document.getElementById("profileImage");

export function handleUploadBook() {
    if (!uploadBookForm || !fileInput || !imagePreview) {
        return;
    }

    fileInput.addEventListener("change", function(event) {
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    uploadBookForm.addEventListener("submit", function(event) {
        event.preventDefault();
    
        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profileImage.value = e.target.result;
                document.getElementById("closeModalBtn").click();
            };
            reader.readAsDataURL(file);
        }
    });
    
}