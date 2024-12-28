





document.getElementById('registerForm').addEventListener('submit', async function(event) {
    event.preventDefault(); // Previeni il comportamento predefinito del form

    const email = document.getElementById('email').value;
    const name = document.getElementById('name').value;
    const surname = document.getElementById('surname').value;
    const password1 = document.getElementById('password1').value;
    const password2 = document.getElementById('password2').value;

    const response = await fetch('../api/router.php/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email, name, surname, password1, password2 })
    });

    const data = await response.json();

    // If responese is beween 200 and 299
    if (response.ok) {
        // Registrazione avvenuta con successo
        window.location.href = 'login.php'; // Redirect to login
    } else {
        // Mostra l'errore
        document.getElementById('errorMessage').innerText = data.error;
    }
});