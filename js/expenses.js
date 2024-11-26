let currentPage = 1; // Current page
const limit = 9; // Number of expenses per page



document.addEventListener('DOMContentLoaded', function() {
    // Load expenses initially
    loadExpenses(currentPage); // Load expenses for the first open
    updateAmounts(); // Update amounts for the first open
});


document.addEventListener('DOMContentLoaded', () => {
    const openPopupBtn = document.getElementById('openPopupBtn');
    const popupForm = document.getElementById('popupForm');

    // Opens the popup and loads users when the button is clicked
    openPopupBtn.addEventListener('click', async () => {
        await openCreatePopup();
    });

    // Closes the popup if clicked outside the popup content
    window.addEventListener('click', (event) => {
        if (event.target === popupForm) {
            popupForm.style.display = 'none';   // popupForm is the container of popup-content
        }
    });
});



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

        // Get data from DB
        const users = await response.json();
        
        // Generate the select user that made the expanse
        const userSelect = document.getElementById('user');
        userSelect.innerHTML = ''; // Clears the select
        const placeholderOption1 = document.createElement('option');
        placeholderOption1.value = '';  // Empty value
        placeholderOption1.textContent = 'Select an user';  // Text to display
        placeholderOption1.setAttribute('disabled', 'true');  // Disable the option
        placeholderOption1.setAttribute('selected', 'true');  // Make it selected by default
        userSelect.appendChild(placeholderOption1);  // Append the placeholder option

        users.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;  // Sets the value as user ID
            option.textContent = `${user.name} ${user.surname}`;  // Text to display as the user's name
            userSelect.appendChild(option);  // Adds the option to the select
        });

        // Genera i checkbox per selezionare gli utenti
        const foruserSelect = document.getElementById('foruser');
        foruserSelect.innerHTML = ''; // Pulisce prima il contenuto


        // Crea dinamicamente i checkbox
        users.forEach(user => {
            const option = document.createElement('label'); // Crea il nuovo label
            option.classList.add('foruser-checkbox'); // Aggiungi la classe

            const input = document.createElement('input'); // Crea l'input checkbox
            input.id = `foruser-${user.id}`;
            input.type = 'checkbox';
            input.name = 'foruser';
            input.value = user.id;
            input.checked = true; // Checkbox selezionato per default
            option.appendChild(input); // Aggiungi l'input al label

            const span = document.createElement('span'); // Crea il testo da visualizzare accanto al checkbox
            span.classList.add('checkmark'); // Classe per il checkmark
            
            const initials = user.name.charAt(0).toUpperCase() + user.surname.charAt(0).toUpperCase();
            span.textContent = initials; // Nome dell'utente
            option.appendChild(span); // Aggiungi il testo al label

            foruserSelect.appendChild(option); // Aggiungi il label (con checkbox e testo) al div
        });

    } catch (error) {
        console.error('Error fetching users:', error);
    }
}


async function loadCategories() {
    try {
        const response = await fetch(`../api/router.php/category`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        const categorySelect = document.getElementById('category');
        categorySelect.innerHTML = ''; // Clears the select

        const placeholderOption1 = document.createElement('option');
        placeholderOption1.value = '';  // Empty value
        placeholderOption1.textContent = 'Select a category';  // Text to display
        placeholderOption1.setAttribute('disabled', 'true');  // Disable the option
        placeholderOption1.setAttribute('selected', 'true');  // Make it selected by default
        categorySelect.appendChild(placeholderOption1);  // Append the placeholder option

        data.forEach(category => {
            const option = document.createElement('option');
            option.value = category.name;  // Sets the value as user ID
            option.textContent = category.name;  // Text to display as the user's name
            categorySelect.appendChild(option);  // Adds the option to the select
        });
    } catch (error) {
        console.error('Error fetching users:', error);
    }
}


async function loadExpenses(page) {
    try {
        const response = await fetch(`../api/router.php/expense/all?page=${page}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();

        // Updates the table body with expenses
        const tableBody = document.querySelector('.payments table tbody');
        tableBody.innerHTML = ''; // Clears the table body

        // Verifies that expenses exist and is an array
        data.expenses.forEach(expense => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${expense.date}</td>
                <td><p>${expense.name} ${expense.surname}</p></td>
                <td>${expense.category}</td>
                <td>${expense.descr}</td>
                <td>${expense.amount.toFixed(2)}€</td>
                <td><i class='bx bx-edit' onclick="openEditPopup(${expense.id}, '${expense.date}', '${expense.user_id}', '${expense.category}', '${expense.descr}', ${expense.amount})"></i></td>
                <td><i class='bx bx-trash' onclick="deleteExpense(${expense.id}, '${expense.date}', '${expense.descr}', ${expense.amount})"></i></td>
            `;
            tableBody.appendChild(row);
        });

        // Adds empty rows for pages with fewer records than the limit
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
        // Updates pagination by passing the current page and total number of pages
        updatePagination(data.current_page, data.total_pages);
    } catch (error) {
        console.error('Error fetching expenses:', error);
    }
}


async function updateAmounts() {
    try {
        const response = await fetch(`../api/router.php/expense/statistics`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        
        const data = await response.json();
        const userList = document.querySelector('.user-list'); // Assicurati che questo selettore sia corretto
        userList.innerHTML = ''; // Svuota la lista prima di aggiungere nuovi dati
        
        // Itera attraverso l'array di dati
        data.forEach(expense => {  // Cambia data.expenses con data
            const userItem = document.createElement('li');
            userItem.className = 'user';

            // Crea un cerchio con l'iniziale del nome
            const firstLetter = expense.name.charAt(0).toUpperCase(); // Prendi la prima lettera del nome
            userItem.innerHTML = `
                <div class="circle">${firstLetter}</div>
                <span class="name">${expense.name} <br> ${expense.surname}</span>
                <div class="amounts">
                    <div class="amount-row">
                        <span class="amount-week">W:</span>
                        <span class="week-value">${expense.weeklyTotal !== null ? expense.weeklyTotal.toFixed(2) : '0.00'}€</span>
                    </div>
                    <div class="amount-row">
                        <span class="amount-month">M:</span>
                        <span class="month-value">${expense.monthlyTotal !== null ? expense.monthlyTotal.toFixed(2) : '0.00'}€</span>
                    </div>
                    <div class="amount-row">
                        <span class="amount-year">Y:</span>
                        <span class="year-value">${expense.yearlyTotal !== null ? expense.yearlyTotal.toFixed(2) : '0.00'}€</span>
                    </div>

                </div>
            `;
            userList.appendChild(userItem);
        });

    } catch (error) {
        console.error('Error updateAmounts:', error);
    }
}


function updatePagination(currentPage, totalPages) {
    const paginationDiv = document.querySelector('.pagination');
    paginationDiv.innerHTML = ''; // Clears the pagination

    // Check if there are pages to display, even if there is only one page
    if (totalPages === 0) {
        totalPages = 1; // Forces the display of page 1 even if there are no items
    }

    // Creates the "previous" link
    const prevLink = document.createElement('a');
    prevLink.href = '#';
    prevLink.innerText = '«';
    prevLink.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentPage > 1) loadExpenses(currentPage - 1);
    });
    paginationDiv.appendChild(prevLink);

    // Creates the links for each page
    for (let i = 1; i <= totalPages; i++) {
        const pageLink = document.createElement('a');
        pageLink.href = '#';
        pageLink.innerText = i;

        // Adds the "active" class for the current page
        if (i === currentPage) {
            pageLink.classList.add('active');
        }

        pageLink.addEventListener('click', (e) => {
            e.preventDefault();
            loadExpenses(i);
        });

        paginationDiv.appendChild(pageLink);
    }

    // Creates the "next" link
    const nextLink = document.createElement('a');
    nextLink.href = '#';
    nextLink.innerText = '»';
    nextLink.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentPage < totalPages) loadExpenses(currentPage + 1);
    });
    paginationDiv.appendChild(nextLink);
}


async function openCreatePopup() {
    document.getElementById('popupForm').style.display = 'flex'; // Displays the popup
    document.querySelector('.popup-title').innerHTML = 'New Expense'; // Changes the title
    // Ensures the form is reset
    const formData = document.getElementById('formData');
    formData.reset(); // Resets the form

    await loadCategories(); // Loads expenses for the first open
    await loadUsers(); // Loads users when the popup is opened
    formData.onsubmit = async (e) => {
        e.preventDefault(); // Prevents page refresh

        // Creates an instance of FormData
        const data = new FormData(formData);

         // Raccogli gli ID degli utenti selezionati dai checkbox
         const selectedUsers = Array.from(document.querySelectorAll('input[name="foruser"]:checked'))
         .map(input => input.value); // Ottieni i valori dei checkbox selezionati

        // Creates the data object to send
        const expenseData = {
            date: data.get('date'),
            user_id: data.get('user'),
            category: data.get('category'),
            descr: data.get('desc'),
            amount: parseFloat(data.get('amount')),
            forusers: JSON.stringify({ users: selectedUsers })
        };

        console.log('Submitted data:', expenseData); // Log for debugging
        await createUpdateExpense('POST', expenseData); // Calls the function to create the expense
        document.getElementById('popupForm').style.display = 'none'; // Hides the popup after submission
    };
}


async function openEditPopup(id, date, userId, category, descr, amount) {
    await loadUsers(); // Loads users when the popup is opened
    await loadCategories(); // Loads categories when the popup is opened

    
    document.querySelector('button[type="submit"]').className = 'edit-button';
    document.querySelector('.popup-title').innerHTML = 'Edit Expense'; // Changes the title
    document.getElementById('popupForm').style.display = 'flex'; // Displays the popup
    document.getElementById('date').value = date; // Pre-fills the date
    document.getElementById('user').value = userId; // Pre-fills the user
    document.getElementById('category').value = category; // Pre-fills the category
    document.getElementById('desc').value = descr; // Pre-fills the description
    document.getElementById('amount').value = amount; // Pre-fills the amount

    // Get the forusers from the API
    try {
        const response = await fetch(`../api/router.php/expense/${id}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        const forusers = JSON.parse(data.forusers).users;
        console.log(forusers);
        
        // Activate the checkboxes based on the forusers
        const checkboxes = document.querySelectorAll('input[name="foruser"]');
        checkboxes.forEach((checkbox) => {
           if (!forusers.includes(checkbox.value)) {
                checkbox.checked = false;
            }
        });
    } catch (error) {
        console.error('Error fetching forusers:', error);
    }


    // Changes the form behavior for updating
    const formData = document.getElementById('formData');
    formData.onsubmit = async (e) => {
        e.preventDefault(); // Prevents page refresh

        // Raccogli gli ID degli utenti selezionati dai checkbox
        const selectedUsers = Array.from(document.querySelectorAll('input[name="foruser"]:checked'))
        .map(input => input.value); // Ottieni i valori dei checkbox selezionati
        // Converto l'array in JSON
        const jsonData = JSON.stringify({ users: selectedUsers });

        const data = new FormData(formData);
        const expenseData = {
            id: id,
            date: data.get('date'),
            user_id: data.get('user'),
            category: data.get('category'),
            descr: data.get('desc'),
            amount: parseFloat(data.get('amount')),
            forusers: JSON.stringify({ users: selectedUsers })
        };

        try {
            console.log('Submitted data:', expenseData); // Log for debugging
            await createUpdateExpense('PUT', expenseData); // Calls the function to update the expense
            document.getElementById('popupForm').style.display = 'none'; // Closes the popup after updating
        } catch (error) {
            console.error('Error updating expense:', error);
        }
    };
}


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

        // Reloads expenses to reflect the change
        loadExpenses(currentPage); // Ensures the correct `currentPage` is loaded
        updateAmounts(); // Updates the amounts of total expenditure
    } catch (error) {
        console.error('Error:', error);
    }
}


async function deleteExpense(id, date, descr, amount) {
    const userConfirmed = confirm("Are you sure you want to delete this expense?" + "\n" + "Date: " + date + "\n" + "Description: " + descr + "\n" + "Amount: " + amount.toFixed(2)  + "€");

    if (userConfirmed) {
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

            loadExpenses(currentPage); // Reloads expenses after deletion
            updateAmounts(); // Updates the amounts of total expenditure
        } catch (error) {
            console.error('Error:', error);
        }
}
}
