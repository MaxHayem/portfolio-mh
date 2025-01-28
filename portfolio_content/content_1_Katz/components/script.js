// Formulaire de contact - Confirmation après soumission
document.getElementById('contactForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Empêche l'envoi réel du formulaire
    alert('Merci pour votre message ! Nous vous répondrons sous peu.');
    this.reset(); // Réinitialise le formulaire
});

// Formulaire d'inscription - afficher input en cliquant sur la checkbox
function toggleInput() {
    var checkbox_pro = document.getElementById('checkbox_pro');
    var societe_nom = document.getElementById('societe_nom');
    if (checkbox_pro.checked) {
        societe_nom.style.display = 'block'; // Afficher l'input text
    } else {
        societe_nom.style.display = 'none'; // Masquer l'input text
    }
}