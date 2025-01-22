const uploadProfileForm = document.getElementById("uploadProfileForm");
const errorMessageUpload = document.getElementById("errorMessage");

// Gestion de l'envoi du formulaire pour le changement de l'image de profil
export function handleFormSubmit() {
    if (!uploadProfileForm) {
        return;
    }
    
    uploadProfileForm.addEventListener("submit", function (event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch("index.php?action=uploadProfileImage", {
            method: "POST",
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                errorMessageUpload.textContent = data.error || "Une erreur est survenue.";
            }
        })
        .catch(error => {
            console.error("Erreur: ", error);
        });
    });
}