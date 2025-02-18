document
  .getElementById("loginform")
  .addEventListener("submit", async function (event) {
    event.preventDefault(); // Previeni il comportamento predefinito del form (invio dei dati e il ricaricamento della pagina)

    const email = document.getElementById("email").value;
    const password = document.getElementById("password").value;

    const response = await fetch("../api/router.php/login", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ email, password }),
    });

    const data = await response.json();

    // If responese is beween 200 and 299
    if (response.ok) {
      // login avvenuto con successo
      window.location.href = "home.php"; // Redirect to login
    } else {
      // Mostra l'errore
      document.getElementById("errorMessage").innerText = data.error;
    }
  });
