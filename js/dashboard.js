// Check if users already joined in a House and display popup
document.addEventListener('DOMContentLoaded', async function(event) {
    try {
        const response = await fetch('../php/script/session.php');
        
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();

        // Controlla se ci sono dati e imposta sessionHouseId
        if (!data.house_id) {
            document.getElementById('popupFormJoinHouse').style.display = 'flex';
        }
        console.log(data); // Mostra tutti i dati ricevuti

        // Set header with house name
        document.getElementById('house-name').innerText = data.house_name;

        document.getElementById('formData').addEventListener('submit', async function(event) {
            event.preventDefault(); // Evita il refresh della pagina
            const house_code = document.getElementById('house_code').value;
            const house_name = document.getElementById('house_name').value;

            // Check if only one of the fields is filled
            if (house_code && house_name) {
                alert('Please fill only one field');
                return;
            } 
            else if (!house_code && !house_name) {
                alert('Please fill at least one field');
                return;
            }
            
            // create house
            if (house_name) {
                const response1 = await fetch('../api/router.php/house', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ house_name }),
                });
                
                
                // Controllo della risposta dal primo fetch
                if (response1.ok) {
                    const data1 = await response1.json(); // Usa response1 per ottenere i dati

                    // Assumendo che data1 contenga house_id
                    const house_id = data1.house_id; // Assicurati che house_id venga restituito

                    const response2 = await fetch('../api/router.php/user', {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ house_id }),
                    });

                    // Controllo della risposta per il secondo fetch
                    if (response2.ok) {
                        // Registrazione avvenuta con successo
                        window.location.href = 'dashboard.php'; // Redirect to login
                    } else {
                        const data2 = await response2.json();
                        document.getElementById('errorMessage').innerText = data2.error;
                    }
                } else {
                    const data1 = await response1.json();
                    document.getElementById('errorMessage').innerText = data1.error;
                }
            
            }
        }); // Corretto posizionamento della chiusura della funzione addEventListener

    } catch (error) {
        console.error('Error:', error);
    }
});
