document.getElementById('formData').addEventListener('submit', async function(event) {
    event.preventDefault(); // Evita il refresh della pagina
    const house_code = document.getElementById('house_code').value;
    const house_name = document.getElementById('house_name').value;

    // Controlla se solo uno dei campi è compilato
    if (house_code && house_name) {
        alert('Please fill only one field');
        return;
    } 
    else if (!house_code && !house_name) {
        alert('Please fill at least one field');
        return;
    }

    let response1; // Definisci la variabile prima dell'uso
    console.log(house_name, house_code);

    // Crea una casa
    if (house_name) {
        response1 = await fetch('../api/router.php/house', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ house_name }),
        });

        // Controllo della risposta
        if (!response1.ok) {
            const errorData = await response1.json();
            document.getElementById('formDataError').innerText = errorData.error || 'Error creating house';
            //alert(errorData.error || 'Error creating house');
            return;
        }
    }
    // Unisciti a una casa
    else if (house_code) {
        response1 = await fetch(`../api/router.php/house/join_code/${encodeURIComponent(house_code)}`, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
            },
        });

        // Controllo della risposta
        if (!response1.ok) {
            const errorData = await response1.json();
            document.getElementById('formDataError').innerText = errorData.error || 'Error joining house';
            //alert(errorData.error || 'Error joining house');
            return;
        }
    }

    const data1 = await response1.json(); // Usa response1 per ottenere i dati
    console.log("::DATA1",  data1);

    // Assumendo che data1 contenga house_id
    const house_id = data1.id; 

    let date = new Date();
    date.setHours(date.getHours() + 2); // Aggiungi 2 ore
    const joinedAt = date.toISOString().slice(0, 19).replace('T', ' ');

    //const joinedAt = new Date().toISOString().slice(0, 19).replace('T', ' ');


    //console.log("::DATA2", { house_id, joinedAt });
    // Aggiungi house_id all'utente
    const response2 = await fetch('../api/router.php/user', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ house_id, joinedAt }),  
    });
    
    const data2 = await response2.json();
    console.log(data2);

    // Controllo della risposta per il secondo fetch
    if (response2.ok) {
        // Registrazione avvenuta con successo
        document.getElementById('popupFormJoinHouse').style.display = 'none';
        window.location.href = 'dashboard.php'; // Redirect to dashboard
    } else {
        alert(data2.error || 'Error updating user');
    }
}); 