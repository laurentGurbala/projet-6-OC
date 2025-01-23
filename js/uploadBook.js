const uploadBookForm = document.getElementById("uploadBookForm");
const errorMessage = document.getElementById("errorMessage");

export function handleUploadBook() {
    if (!uploadBookForm) {
        return;
    }

    uploadBookForm.addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        const bookId = document.querySelector("input[name='bookId']").value;

        fetch("index.php?action=uploadBookImage&id=" + bookId, {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }else {
                errorMessage.textContent = data.error || "Une erreur est survenue.";
            }
        })
        .catch(error => {
            console.error("Erreur: ", error);
        })
    })
}