let currentPage = 1; // Current page
const limit = 9; // Number of expenses per page

// Load expenses initially
loadPayments(currentPage); // Load expenses for the first open
updateSettleUp(); // Update amounts for the first open


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

        const data = await response.json(); // Potrebbe generare un errore se non è un JSON valido

        
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


async function updateSettleUp() {
    try {
        const response = await fetch(`../api/router.php/payment/settleup`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        
        const data = await response.json();
        const userList = document.querySelector('.settleup-list'); 
        userList.innerHTML = ''; // Svuota la lista prima di aggiungere nuovi dati
        
        let check_if_something_is_printed = false;
        // Itera attraverso l'array di dati
        data.forEach(expense => {  
            if (expense.amount >= 0.01){    // Prevengo che stampi 0.00 per gli arrotondamenti
            const settleupItem = document.createElement('li');
            settleupItem.className = 'setteup-element';

                console.log(expense);
                settleupItem.innerHTML = `
                    <div class="users">    
                        <div><span>From: </span> ${expense.name_user_from}  ${expense.surname_user_from}</div>
                        <div><span>To: </span> ${expense.name_user_to}  ${expense.surname_user_to}</div>
                    </div>
                    <div class="right">
                        <span class="amount">${expense.amount.toFixed(2)}€</span>
                        <button type="submit" onclick="openCreatePopup(${expense.id_user_from}, '${expense.id_user_to}', ${expense.amount})">Settle</button>
                    </div>
                    `;

                check_if_something_is_printed = true;
                
                userList.appendChild(settleupItem);
            }
        });

        if (!check_if_something_is_printed) {
            const settleupItem = document.createElement('li');
            settleupItem.className = 'setteup-element';
            settleupItem.innerHTML = `
                <div class="users">    
                    <div>"Ooh, lucky us! <br>Looks like we're all squared away for now!</div>
                </div>
                `;
            userList.appendChild(settleupItem);
        }

    } catch (error) {
        console.error('Error updateSettleUp:', error);
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


async function openCreatePopup(id_user_from, id_user_to, amount) {
    await loadUsers(); // Loads users when the popup is opened
    document.getElementById('popupForm').style.display = 'flex'; // Displays the popup
    document.querySelector('.popup-title').innerHTML = 'New Payment'; // Changes the title
    
    // Ensures the form is reset
    const formData = document.getElementById('formData');
    formData.reset(); // Resets the form

    // Pre-fills the form with settleup data
    if (id_user_from && id_user_to && amount) {
        document.getElementById('date').value = new Date().toISOString().split('T')[0]; // Pre-fills the date
        // Nota:
        // new Date(): Crea un oggetto data con la data corrente.
        // .toISOString(): Converte la data in formato ISO 8601 completo (es: 2024-11-26T14:30:00.000Z).
        // .split('T')[0]: Estrae solo la parte relativa alla data (YYYY-MM-DD), eliminando l'ora
        
        document.getElementById('user_from').value = id_user_from; // Pre-fills the user
        document.getElementById('user_to').value = id_user_to; // Pre-fills the user
        document.getElementById('amount').value = parseFloat(amount).toFixed(2); // Pre-fills the amount
    }

    formData.onsubmit = async (e) => {
        e.preventDefault(); // Prevents page refresh

        // Creates an instance of FormData
        const data = new FormData(formData);

        // Creates the data object to send
        const paymentData = {
            date: data.get('date'),
            id_user_from: data.get('user_from'),
            id_user_to: data.get('user_to'),
            payment_method: data.get('method'),
            amount: parseFloat(data.get('amount')),
        };
        
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
        
        const response = await fetch(`../api/router.php/payment`, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
        
        if (!response.ok) {
            throw new Error('Failed to ' + method + ' payment');
        }

        // Reloads expenses to reflect the change
        loadPayments(currentPage); // Ensures the correct `currentPage` is loaded
        
        updateSettleUp(); // Updates the amounts of total expenditure
    } catch (error) {
        console.error('Error:', error);
    }
}


async function deletePayment(id, date) {
    const userConfirmed = confirm("Are you sure you want to delete this payment?" + "\n" + "Date: " + date + "\n");

    if (userConfirmed) {
        try {
            const response = await fetch(`../api/router.php/payment/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                },
            });

            if (!response.ok) {
                throw new Error('Failed to delete payment');
            }

            loadPayments(currentPage); // Reloads expenses after deletion
            updateSettleUp(); // Updates the amounts of total expenditure
        } catch (error) {
            console.error('Error:', error);
        }
    }
}
