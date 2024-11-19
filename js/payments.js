let currentPage = 1; // Current page
const limit = 9; // Number of expenses per page

// Load expenses initially
loadPayments(currentPage); // Load expenses for the first open
updateAmounts(); // Update amounts for the first open


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
        const data = await response.json();
        
        const userSelect1 = document.getElementById('user_from');
        userSelect1.innerHTML = ''; // Clears the select
        
        
        const placeholderOption1 = document.createElement('option');
        placeholderOption1.value = '';  // Empty value
        placeholderOption1.textContent = 'Select an user';  // Text to display
        placeholderOption1.setAttribute('disabled', 'true');  // Disable the option
        placeholderOption1.setAttribute('selected', 'true');  // Make it selected by default
        userSelect1.appendChild(placeholderOption1);  // Append the placeholder option
        
        data.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;  // Sets the value as user ID
            option.textContent = `${user.name} ${user.surname}`;  // Text to display as the user's name
            option.disabled = false;
            option.selected = false;
            userSelect1.appendChild(option);  // Adds the option to the select
        });

        const userSelect2 = document.getElementById('user_to');
        userSelect2.innerHTML = ''; // Clears the select
        
        const placeholderOption2 = document.createElement('option');
        placeholderOption2.value = '';  // Empty value
        placeholderOption2.textContent = 'Select an user';  // Text to display
        placeholderOption2.setAttribute('disabled', 'true');  // Disable the option
        placeholderOption2.setAttribute('selected', 'true');  // Make it selected by default
        userSelect2.appendChild(placeholderOption2);  // Append the placeholder option
        

        data.forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;  // Sets the value as user ID
            option.textContent = `${user.name} ${user.surname}`;  // Text to display as the user's name
            userSelect2.appendChild(option);  // Adds the option to the select
        });
    } catch (error) {
        console.error('Error fetching users:', error);
    }
}

async function loadPayments(page) {
    try {
        const response = await fetch(`../api/router.php/payment/all?page=${page}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            const errorText = await response.text(); // Legge la risposta come testo
            throw new Error(`Network response was not ok: ${errorText}`);
        }

        console.log("::RESPONSE", response);
        const data = await response.json(); // Potrebbe generare un errore se non è un JSON valido
        console.log("::DATA", data);
        
        // Aggiorna la tabella e gestisce i pagamenti
        const tableBody = document.querySelector('.payments table tbody');
        tableBody.innerHTML = ''; // Pulisce il corpo della tabella

        data.payments.forEach(payment => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${payment.date}</td>
                <td><p>${payment.user_from_name} ${payment.user_from_surname}</p></td>
                <td><p>${payment.user_to_name} ${payment.user_to_surname}</p></td>
                <td>${payment.payment_method}</td>
                <td>${payment.amount.toFixed(2)}€</td>
                <td><i class='bx bx-edit' onclick="openEditPopup(${payment.id}, '${payment.date}', '${payment.id_user_from}', '${payment.id_user_to}', '${payment.payment_method}', ${payment.amount})"></i></td>
                <td><i class='bx bx-trash' onclick="deletePayment(${payment.id}, '${payment.date}')"></i></td>
            `;
            tableBody.appendChild(row);
        });

        const numRows = data.payments.length;
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

        updatePagination(data.current_page, data.total_pages);
    } catch (error) {
        console.error('Error fetching payments:', error.message || error);
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

        //console.log(':::RESPONSE', response);
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
        if (currentPage > 1) loadPayments(currentPage - 1);
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
            loadPayments(i);
        });

        paginationDiv.appendChild(pageLink);
    }

    // Creates the "next" link
    const nextLink = document.createElement('a');
    nextLink.href = '#';
    nextLink.innerText = '»';
    nextLink.addEventListener('click', (e) => {
        e.preventDefault();
        if (currentPage < totalPages) loadPayments(currentPage + 1);
    });
    paginationDiv.appendChild(nextLink);
}


async function openCreatePopup() {
    await loadUsers(); // Loads users when the popup is opened
    document.getElementById('popupForm').style.display = 'flex'; // Displays the popup

    // Ensures the form is reset
    const formData = document.getElementById('formData');
    formData.reset(); // Resets the form

    formData.onsubmit = async (e) => {
        e.preventDefault(); // Prevents page refresh

        // Creates an instance of FormData
        const data = new FormData(formData);

        console.log("::DATA0", data);
        // Creates the data object to send
        const paymentData = {
            date: data.get('date'),
            id_user_to: data.get('user_to'),
            id_user_from: data.get('user_from'),
            payment_method: data.get('method'),
            amount: parseFloat(data.get('amount')),
        };
        console.log("::paymentData", paymentData);
        //console.log('Submitted data:', expenseData); // Log for debugging
        await createUpdatePayment('POST', paymentData); // Calls the function to create the expense
        document.getElementById('popupForm').style.display = 'none'; // Hides the popup after submission
    };
}


async function openEditPopup(id, date, id_user_from, id_user_to, payment_method, amount) {
    await loadUsers(); // Loads users when the popup is opened
    document.querySelector('button[type="submit"]').className = 'edit-button';
    document.querySelector('.popup-title').innerHTML = 'Edit Payment'; // Changes the title
    document.getElementById('popupForm').style.display = 'flex'; // Displays the popup
    document.getElementById('date').value = date; // Pre-fills the date
    document.getElementById('user_from').value = id_user_from; // Pre-fills the user
    document.getElementById('user_to').value = id_user_to; // Pre-fills the user
    document.getElementById('method').value = payment_method; // Pre-fills the description
    document.getElementById('amount').value = amount; // Pre-fills the amount

    // Changes the form behavior for updating
    const formData = document.getElementById('formData');
    formData.onsubmit = async (e) => {
        e.preventDefault(); // Prevents page refresh

        const data = new FormData(formData);

        const paymentData = {
            id, 
            date: data.get('date'),
            id_user_to: data.get('user_to'),
            id_user_from: data.get('user_from'),
            payment_method: data.get('method'),
            amount: parseFloat(data.get('amount')),
        };

        console.log('Submitted data:', paymentData); // Log for debugging

        try {
            await createUpdatePayment('PUT', paymentData); // Calls the function to update the expense
            document.getElementById('popupForm').style.display = 'none'; // Closes the popup after updating
        } catch (error) {
            console.error('Error updating payments:', error);
        }
    };
}


async function createUpdatePayment(method, data) {
    try {
        console.log("::DATA", data);
        const response = await fetch(`../api/router.php/payment`, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
        console.log("::CREATE_PAYMETS", response);
        if (!response.ok) {
            throw new Error('Failed to ' + method + ' expense');
        }

        // Reloads expenses to reflect the change
        loadPayments(currentPage); // Ensures the correct `currentPage` is loaded
        console.log("Reloaded Payments OK")
        updateAmounts(); // Updates the amounts of total expenditure
    } catch (error) {
        console.error('Error:', error);
    }
}


async function deletePayment(id, date) {
    const userConfirmed = confirm("Are you sure you want to delete this expense?" + "\n" + "Date: " + date + "\n");

    if (userConfirmed) {
        try {
            const response = await fetch(`../api/router.php/payment/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error('Failed to delete expense');
            }

            loadPayments(currentPage); // Reloads expenses after deletion
            updateAmounts(); // Updates the amounts of total expenditure
        } catch (error) {
            console.error('Error:', error);
        }
    }
}
