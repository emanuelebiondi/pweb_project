
// Seleziona gli elementi del DOM
const openPopupBtn = document.getElementById('openPopupBtn');
const popupForm = document.getElementById('popupForm');
const closeBtn = document.querySelector('.close-btn');

// Apre il popup quando si clicca sul bottone
openPopupBtn.addEventListener('click', () => {
    popupForm.style.display = 'flex'; // Mostra il popup
});

// Chiude il popup quando si clicca sulla X
closeBtn.addEventListener('click', () => {
    popupForm.style.display = 'none'; // Nasconde il popup
});

// Chiude il popup se si clicca al di fuori del contenuto del popup
window.addEventListener('click', (event) => {
    if (event.target == popupForm) {
        popupForm.style.display = 'none';
    }
});


// TODO:Controll logich to check if user as already joined in a House
window.addEventListener('click', (event) => {
    if (event.target == popupForm) {
        popupForm.style.display = 'none';
    }
});



mobiscroll.select('#single-select', {
    inputElement: document.getElementById('my-input'),
    touchUi: false
});

// Gestisce l'invio del form (puoi aggiungere la logica per inviare i dati tramite AJAX)
document.getElementById('formData').addEventListener('submit', function(event) {
    event.preventDefault(); // Evita il refresh della pagina
    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;

    console.log('Dati inviati:', { name, email });

    // Puoi aggiungere qui la logica per inviare i dati tramite AJAX
    popupForm.style.display = 'none'; // Nasconde il popup dopo l'invio
});