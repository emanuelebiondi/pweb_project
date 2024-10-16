let currentPage = 1; // Pagina corrente
const limit = 9; // Numero di spese per pagina

// Carica le spese inizialmente
loadExpenses(currentPage); // Load expenses for the first open



document.addEventListener('DOMContentLoaded', () => {
    const openPopupBtn = document.getElementById('openPopupBtn');
    const popupForm = document.getElementById('popupForm');

    // Apre il popup e carica gli utenti quando si clicca sul bottone
    openPopupBtn.addEventListener('click', async () => {
        await openCreatePopup();
    });

    // Chiude il popup se si clicca al di fuori del contenuto del popup
    window.addEventListener('click', (event) => {
        if (event.target === popupForm) {
            popupForm.style.display = 'none';   // popupForm is the container of popup-content
        }
    });
});



/**
 * Asynchronously loads users from the API and populates the user select dropdown.
 * 
 * Fetches user data from '../api/router.php/user' using a GET request. If the response 
 * is successful, clears the existing options in the user select dropdown and adds new 
 * options for each user retrieved from the API. Each option's value is set to the user's ID,
 * and the displayed text is a combination of the user's name and surname.
 * 
 * In case of an error during the fetch operation, logs an error message to the console.
 */
async function loadUsers() {
    try {
        const response = await fetch(`../api/router.php/user`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        const userSelect = document.getElementById('user');
        userSelect.innerHTML = ''; // Svuota il select

        data.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;  // Imposta il value come ID utente
            option.textContent = `${user.name} ${user.surname}`;  // Testo da mostrare come nome utente
            userSelect.appendChild(option);  // Aggiungi l'opzione al select
        });
    } catch (error) {
        console.error('Error fetching users:', error);
    }
}


/**
 * Fetches the expenses from the API and updates the table with the expenses.
 *
 * @param {number} page The page number to fetch.
 * @throws {Error} If the network response is not OK.
 */
async function loadExpenses(page) {
    try {
        const response = await fetch(`../api/router.php/expense?page=${page}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();

        // Aggiorna il corpo della tabella con le spese
        const tableBody = document.querySelector('.payments table tbody');
        tableBody.innerHTML = ''; // Svuota il corpo della tabella

        // Verifica che expenses esista e sia un array
        data.expenses.forEach(expense => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${expense.date}</td>
                <td><p>${expense.name} ${expense.surname}</p></td>
                <td>${expense.category}</td>
                <td>${expense.descr}</td>
                <td>${expense.amount}€</td>
                <td><i class='bx bx-edit' onclick="openEditPopup(${expense.id}, '${expense.date}', '${expense.user_id}', '${expense.category}', '${expense.descr}', ${expense.amount})"></i></td>
                <td><i class='bx bx-trash' onclick="deleteExpense(${expense.id})"></i></td>
            `;
            tableBody.appendChild(row);
        });

        // Aggiunge le righe vuote per le pagine con meno record di limit
        const numRows = data.expenses.length;
        if (numRows < limit) {
            const emptyRows = limit - numRows;
            for (let i = 0; i < emptyRows; i++) {
                const emptyRow = document.createElement('tr');
                emptyRow.innerHTML = `
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                `;
                tableBody.appendChild(emptyRow);
            }
        }

        // Aggiorna la paginazione passando il numero di pagine e la pagina corrente
        updatePagination(data.current_page, data.total_pages);
    } catch (error) {
        console.error('Error fetching expenses:', error);
    }
}


/**
 * Updates the pagination controls on the page based on the current and total number of pages.
 * Creates and attaches "previous", "next", and individual page number links to the pagination section.
 * Handles click events to load expenses for the selected page.
 *
 * @param {number} currentPage - The current active page number.
 * @param {number} totalPages - The total number of pages available.
 */
function updatePagination(currentPage, totalPages) {
    const paginationDiv = document.querySelector('.pagination');
    paginationDiv.innerHTML = ''; // Svuota la paginazione

    // Verifica se ci sono pagine da visualizzare, anche se c'è solo una pagina
    if (totalPages === 0) {
        totalPages = 1; // Forza la visualizzazione della pagina 1 anche se non ci sono elementi
    }

    // Crea il link "precedente"
    const prevLink = document.createElement('a');
    prevLink.href = '#';
    prevLink.innerText = '«';
    prevLink.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentPage > 1) loadExpenses(currentPage - 1);
    });
    paginationDiv.appendChild(prevLink);

    // Crea i link per ogni pagina
    for (let i = 1; i <= totalPages; i++) {
        const pageLink = document.createElement('a');
        pageLink.href = '#';
        pageLink.innerText = i;

        // Aggiungi la classe "active" per la pagina corrente
        if (i === currentPage) {
            pageLink.classList.add('active');
        }

        pageLink.addEventListener('click', (e) => {
            e.preventDefault();
            loadExpenses(i);
        });

        paginationDiv.appendChild(pageLink);
    }

    // Crea il link "successivo"
    const nextLink = document.createElement('a');
    nextLink.href = '#';
    nextLink.innerText = '»';
    nextLink.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentPage < totalPages) loadExpenses(currentPage + 1);
    });
    paginationDiv.appendChild(nextLink);
}


/**
 * Opens the create popup with pre-filled data for creating a new expense.
 * Loads users when the popup is opened and sets the form fields with default values.
 * Handles the form submission to create a new expense.
 */
async function openCreatePopup() {
    await loadUsers(); // Carica gli utenti quando il popup viene aperto
    document.getElementById('popupForm').style.display = 'flex'; // Mostra il popup

    // Assicurati di resettare il form
    const formData = document.getElementById('formData');
    formData.reset(); // Resetta il form

    formData.onsubmit = async (e) => {
        e.preventDefault(); // Impedisce il refresh della pagina

        // Crea un'istanza di FormData
        const data = new FormData(formData);

        // Crea l'oggetto dati da inviare
        const expenseData = {
            date: data.get('date'),
            user_id: data.get('user'),
            category: data.get('category'),
            descr: data.get('desc'),
            amount: parseFloat(data.get('amount')),
        };

        //console.log('Dati inviati:', expenseData); // Log per il debug
        await createUpdateExpense('POST', expenseData); // Chiama la funzione per creare la spesa
        document.getElementById('popupForm').style.display = 'none'; // Nasconde il popup dopo l'invio
    };
}


/**
 * Opens the edit popup with pre-filled data for editing an expense.
 * Loads users when the popup is opened and sets the form fields with existing expense data.
 * Handles the form submission to update the expense.
 * @param {number} id - The ID of the expense to edit.
 * @param {string} date - The date of the expense.
 * @param {number} userId - The user ID associated with the expense.
 * @param {string} category - The category of the expense.
 * @param {string} descr - The description of the expense.
 * @param {number} amount - The amount of the expense.
 */
async function openEditPopup(id, date, userId, category, descr, amount) {
    await loadUsers(); // Carica gli utenti quando il popup viene aperto
    document.querySelector('button[type="submit"]').className = 'edit-button';
    document.querySelector('.popup-title').innerHTML = 'Edit Expense'; // Cambia il titolo
    document.getElementById('popupForm').style.display = 'flex'; // Mostra il popup
    document.getElementById('date').value = date; // Precompila la data
    document.getElementById('user').value = userId; // Precompila l'utente
    document.getElementById('category').value = category; // Precompila la categoria
    document.getElementById('desc').value = descr; // Precompila la descrizione
    document.getElementById('amount').value = amount; // Precompila l'importo

    // Cambia il comportamento del form per l'aggiornamento
    const formData = document.getElementById('formData');
    formData.onsubmit = async (e) => {
        e.preventDefault(); // Impedisce il refresh della pagina

        const data = new FormData(formData);
        const expenseData = {
            id: id,
            date: data.get('date'),
            user_id: data.get('user'),
            category: data.get('category'),
            descr: data.get('desc'),
            amount: parseFloat(data.get('amount')),
        };

       // console.log('Dati inviati:', expenseData); // Log per il debug

        try {
            await createUpdateExpense('PUT', expenseData); // Chiama la funzione per aggiornare la spesa
            document.getElementById('popupForm').style.display = 'none'; // Chiudi il popup dopo l'aggiornamento
        } catch (error) {
            console.error('Error updating expense:', error);
        }
    };
}


/**
 * Creates or updates an expense, given the HTTP method and the expense data.
 * @param {string} method - The HTTP method to use, either 'POST' or 'PUT'.
 * @param {object} data - The expense data to send. Must contain the following properties:
 *  - id (optional): The ID of the expense to update.
 *  - date: The date of the expense.
 *  - user_id: The ID of the user who made the expense.
 *  - category: The category of the expense.
 *  - descr: The description of the expense.
 *  - amount: The amount of the expense.
 * @throws {Error} If the request fails.
 */
async function createUpdateExpense(method, data) {
    try {
        const response = await fetch(`../api/router.php/expense`, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });

        if (!response.ok) {
            throw new Error('Failed to ' + method + ' expense');
        }

        // Ricarica le spese per riflettere la modifica
        loadExpenses(currentPage); // Assicurati di avere `currentPage` corretto
    } catch (error) {
        console.error('Error:', error);
    }
}


/**
 * Deletes an expense with the given ID.
 * @param {number} id - The ID of the expense to delete.
 * @throws {Error} If the request fails.
 */
async function deleteExpense(id) {
    try {
        const response = await fetch(`../api/router.php/expense/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Failed to delete expense');
        }

        loadExpenses(currentPage); // Ricarica le spese dopo l'eliminazione
    } catch (error) {
        console.error('Error:', error);
    }
}
