// Riferimenti agli elementi del DOM
const addPostitBtn = document.getElementById("task-new");
const postitsContainer = document.getElementById("task-list");

// Carica i post-it all'avvio della pagina
document.addEventListener('DOMContentLoaded', function() {
    loadReminders(); // Carica i post-it quando la pagina è pronta
});

// Aggiunge un nuovo post-it quando viene cliccato il pulsante
addPostitBtn.addEventListener('click', () => {
    createUpdateReminder('POST', { text: "Write something cool!" }).then(() => {
        loadReminders();  // Ricarica i post-it dopo aver aggiunto un nuovo post-it
    });
});

// Funzione per creare o aggiornare un post-it
function createPostit(data) {
    const tasklist = document.getElementById("task-list");

    // Crea il nuovo post-it
    const task = document.createElement("li");
    task.classList.add("task-element");
    task.setAttribute("id", data.id); // Imposta l'ID del post-it
    task.innerHTML = `
        <div class="task-text">
            <textarea maxlength="240">${data.text}</textarea>
        </div>
        <span class="delete-btn">Delete</span>
    `;

    // Seleziona l'ultimo elemento esistente della lista (il bottone)
    const lastItem = tasklist.querySelector(".task-new");

    // Gestisce l'evento di modifica (cliccando per entrare in modalità editing)
    task.addEventListener("click", () => {
        task.classList.add("editing");
        task.querySelector("textarea").focus(); // Aggiungi il focus sulla textarea
    });

    // Gestisce la perdita del focus (salvataggio dei contenuti)
    task.querySelector("textarea").addEventListener("blur", (event) => {
        task.classList.remove("editing");
        const updatedText = event.target.value;
        createUpdateReminder('PUT', { id: data.id, text: updatedText }); // Salva la modifica nel DB
    });

    // Gestisce il click sul bottone "Delete" per rimuovere il post-it
    task.querySelector(".delete-btn").addEventListener("click", (event) => {
        tasklist.removeChild(task);
        deleteReminder(data.id); // Rimuovi il post-it dal DB
    });

    // Aggiunge il nuovo post-it prima dell'elemento bottone (l'ultimo della lista)
    tasklist.insertBefore(task, lastItem);
}

// Funzione per salvare o aggiornare i post-it nel DB
async function createUpdateReminder(method, data) {
    try {
        const response = await fetch(`../api/router.php/reminder`, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data), // Passa i dati come JSON
        });

        if (!response.ok) {
            throw new Error('Failed to ' + method + ' reminder');
        }

        // Il post-it è stato creato o aggiornato con successo
        const result = await response.json();
        console.log(result);
        return result;

    } catch (error) {
        console.error('Error:', error);
    }
}

// Funzione per ottenere tutti i post-it dal DB
async function getReminders() {
    try {
        const response = await fetch(`../api/router.php/reminder`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Failed to get reminders or no reminders found');
        }

        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error:', error);
    }
}

// Funzione per caricare i post-it dal DB e visualizzarli
function loadReminders() {
    getReminders().then((reminders) => {
        // Prima di caricare, controlla che reminders non sia null o undefined
        if (reminders && Array.isArray(reminders) && reminders.length > 0) {
            // Rimuovi tutti i post-it esistenti prima di caricare i nuovi
            postitsContainer.innerHTML = "";

            // Per ogni post-it, controlla che abbia un id e un testo valido
            reminders.forEach((reminder) => {
                if (reminder && reminder.id && reminder.text) {
                    const data = {
                        id: reminder.id,
                        text: reminder.text
                    };
                    createPostit(data); // Crea il post-it
                } else {
                    console.warn("Reminder manca di id o text", reminder);
                }
            });
        } else {
            console.warn("Nessun reminder disponibile o la risposta è vuota.");
        }

        // Aggiungi il bottone di creazione dopo aver caricato tutti i post-it
        if (!postitsContainer.querySelector(".task-new")) {
            const taskNew = document.createElement("li");
            taskNew.classList.add("task-new");
            taskNew.setAttribute("id", "task-new");
            taskNew.innerHTML = `<button>+</button>`;
            taskNew.addEventListener('click', () => {
                createUpdateReminder('POST', { text: "Write something cool!" }).then(() => {
                    loadReminders();  // Ricarica i post-it dopo aver aggiunto un nuovo post-it
                });
            });
            postitsContainer.appendChild(taskNew);
        }
    });
}

// Funzione per eliminare un post-it dal DB
async function deleteReminder(id) {
    try {
        const response = await fetch(`../api/router.php/reminder/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Failed to delete reminder');
        }

        // Successo nell'eliminazione del post-it
        console.log(`Post-it con ID ${id} eliminato`);
    } catch (error) {
        console.error('Error:', error);
    }
}
