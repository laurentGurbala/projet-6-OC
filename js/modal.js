const openModalBtn = document.getElementById("openModalBtn");
const closeModalBtn = document.getElementById("closeModalBtn");
const modal = document.getElementById("uploadModal");

// Fonction pour ouvrir la modale
export function openModal() {
    modal.style.display = "block";    
}

// Fonction pour fermer la modale
export function closeModal() {
    modal.style.display = "none";
}

// Écouteurs d'événements pour ouvrir et fermer la modale
export function handleModalEvents() {
    if (openModalBtn && closeModalBtn) {
        openModalBtn.addEventListener("click", openModal);
        closeModalBtn.addEventListener("click", closeModal);
    }
}