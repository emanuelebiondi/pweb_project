// Carica i category all'avvio della pagina
document.addEventListener("DOMContentLoaded", function () {
  loadCategories(); // Carica i category quando la pagina è pronta

  // Aggiunge un nuovo category quando viene cliccato il pulsante
  const addCategoryBtn = document.getElementById("addCategoryBtn");
  addCategoryBtn.addEventListener("click", () => {
    createUpdateCategory("POST", { name: "New Category" }).then(() => {
      loadCategories(); // Ricarica i category dopo aver aggiunto un nuovo category
    });
  });

  const changePwdBtn = document.getElementById("changePasswordBtn");
  changePwdBtn.addEventListener("click", () => {
    const oldPwd = document.getElementById("old_password").value;
    const newPwd = document.getElementById("new_password1").value;
    const confPwd = document.getElementById("new_password2").value;

    if ( oldPwd !== "" && newPwd !== "" && confPwd !== "") 
      passwordChange(oldPwd, newPwd, confPwd);
  });
});

// Funzione per creare o aggiornare un category
function createCategory(data) {
  const categorylist = document.getElementById("categorySpace");

  // Crea il nuovo category
  const cat = document.createElement("div");
  cat.classList.add("category-element");
  cat.setAttribute("id", data.id); // Imposta l'ID del category
  cat.innerHTML = `
        <textarea maxlength="20" id="dl${data.id}" required>${data.name}</textarea>
        <button class="delete-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
            <path fill="currentColor" d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"/>
            <path fill="currentColor" d="M9 10h2v8H9zm4 0h2v8h-2z"/>
        </svg>
        </button>
    `;

  // Gestisce l'evento di modifica (cliccando per entrare in modalità editing)
  cat.addEventListener("click", () => {
    cat.classList.add("editing");
    cat.querySelector("textarea").focus(); // Aggiungi il focus sulla textarea
  });

  // Gestisce la perdita del focus (salvataggio dei contenuti)
  cat.querySelector("textarea").addEventListener("blur", (event) => {
    cat.classList.remove("editing");
    const updatedText = event.target.value;
    createUpdateCategory("PUT", { id: data.id, name: updatedText }); // Salva la modifica nel DB
  });

  // Gestisce il click sul bottone "Delete" per rimuovere il category
  cat.querySelector(".delete-btn").addEventListener("click", (event) => {
    categorylist.removeChild(cat);
    deleteCategory(data.id); // Rimuovi il category dal DB
  });
  categorylist.appendChild(cat);
}

// Funzione per salvare o aggiornare i category nel DB
async function createUpdateCategory(method, data) {
  try {
    const response = await fetch(`../api/router.php/category`, {
      method: method,
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data), // Passa i dati come JSON
    });

    if (!response.ok) {
      throw new Error("Failed to " + method + " category");
    }

    // Category creato o aggiornato con successo
    const result = await response.json();
    //console.log(result);
    return result;
  } catch (error) {
    console.error("Error:", error);
  }
}

// Funzione per ottenere tutti i category dal DB
async function getCategories() {
  try {
    const response = await fetch(`../api/router.php/category`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (!response.ok) {
      throw new Error("Failed to get category or no category found");
    }

    const data = await response.json();
    //console.log(":::DATA", data);
    return data;
  } catch (error) {
    console.error("Error:", error);
  }
}

// Funzione per caricare i category dal DB e visualizzarli
function loadCategories() {
  getCategories().then((category) => {
    // Prima di caricare, controlla che category non sia null o undefined
    if (category && Array.isArray(category) && category.length > 0) {
      // Rimuovi tutti i category esistenti prima di caricare i nuovi
      const categoryContainer = document.getElementById("categorySpace");
      categoryContainer.innerHTML = "";

      // Per ogni category, controlla che abbia un id e un testo valido
      category.forEach((category) => {
        if (category && category.id) {
          const data = {
            id: category.id,
            name: category.name,
          };
          createCategory(data); // Crea il category
        } else {
          console.warn("Category manca di id o text", category);
        }
      });
    } else {
      console.warn("Nessun category disponibile o la risposta è vuota.");
    }
  });
}

// Funzione per eliminare un category dal DB
async function deleteCategory(id) {
  try {
    const response = await fetch(`../api/router.php/category/${id}`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
      },
    });

    if (!response.ok) {
      throw new Error("Failed to delete category");
    }
  } catch (error) {
    console.error("Error:", error);
  }
}

// Funzione per cambiare la password
async function passwordChange(oldPwd, newPwd, confPwd) {
  try {
    const response = await fetch(`../api/router.php/passwordChange`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ oldPwd, newPwd, confPwd }),
    });

    const data = await response.json();

    if (response.ok) {
      // Registrazione avvenuta con successo
      document.getElementById("message").innerText =
        "Password changed successfully";
    } else {
      // Mostra l'errore
      document.getElementById("message").innerText = data.error;
    }
  } catch (error) {
    console.error("Error:", error);
  }
}
