// Riferimenti agli elementi del DOM
const addCategorytBtn = document.getElementById("addCategoryBtn");
const categoryContainer = document.getElementById("categorySpace");

// Carica i post-it all'avvio della pagina
document.addEventListener('DOMContentLoaded', function() {
    loadCategorys(); // Carica i post-it quando la pagina è pronta
});

// Aggiunge un nuovo post-it quando viene cliccato il pulsante
addCategorytBtn.addEventListener('click', () => {
    createUpdateCategory('POST', { name: "New Category" }).then(() => {
        loadCategorys();  // Ricarica i post-it dopo aver aggiunto un nuovo post-it
    });
});

// Funzione per creare o aggiornare un post-it
function createPostit(data) {
    const categorylist = document.getElementById("categorySpace");

    // Crea il nuovo post-it
    const cat = document.createElement("div");
    cat.classList.add("category-element");
    cat.setAttribute("id", data.id); // Imposta l'ID del post-it
    cat.innerHTML = `
        <textarea maxlength="20">${data.name}</textarea>
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
        createUpdateCategory('PUT', { id: data.id, name: updatedText }); // Salva la modifica nel DB
    });

    // Gestisce il click sul bottone "Delete" per rimuovere il post-it
    cat.querySelector(".delete-btn").addEventListener("click", (event) => {
        categorylist.removeChild(cat);
        deleteCategory(data.id); // Rimuovi il category dal DB
    });
    categorylist.appendChild(cat);

}

// Funzione per salvare o aggiornare i post-it nel DB
async function createUpdateCategory(method, data) {
    try {
        const response = await fetch(`../api/router.php/category`, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data), // Passa i dati come JSON
        });

        if (!response.ok) {
            throw new Error('Failed to ' + method + ' category');
        }

        // Category creato o aggiornato con successo
        const result = await response.json();
        //console.log(result);
        return result;

    } catch (error) {
        console.error('Error:', error);
    }
}

// Funzione per ottenere tutti i post-it dal DB
async function getCategorys() {
    try {
        const response = await fetch(`../api/router.php/category`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Failed to get category or no category found');
        }

        const data = await response.json();
        //console.log(":::DATA", data);
        return data;
    } catch (error) {
        console.error('Error:', error);
    }
}

// Funzione per caricare i post-it dal DB e visualizzarli
function loadCategorys() {
    getCategorys().then((category) => {
        // Prima di caricare, controlla che category non sia null o undefined
        if (category && Array.isArray(category) && category.length > 0) {
            // Rimuovi tutti i post-it esistenti prima di caricare i nuovi
            categoryContainer.innerHTML = "";

            // Per ogni post-it, controlla che abbia un id e un testo valido
            category.forEach((category) => {
                if (category && category.id ) {
                    const data = {
                        id: category.id,
                        name: category.name
                    };
                    createPostit(data); // Crea il post-it
                } else {
                    console.warn("Category manca di id o text", category);
                }
            });
        } else {
            console.warn("Nessun category disponibile o la risposta è vuota.");
        }

    });
}

// Funzione per eliminare un post-it dal DB
async function deleteCategory(id) {
    try {
        const response = await fetch(`../api/router.php/category/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Failed to delete category');
        }

       
    } catch (error) {
        console.error('Error:', error);
    }
}
