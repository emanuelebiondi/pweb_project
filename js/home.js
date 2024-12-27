// Check if users already joined in a House and display popup
document.addEventListener('DOMContentLoaded', async function(event) {
    try {
        const response = await fetch('../php/script/session.php');

        // Verifica se la risposta della rete è corretta
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();

        // Controlla se ci sono dati e imposta sessionHouseId
        if (!data.house_id) {
            document.getElementById('popupFormJoinHouse').style.display = 'flex';
        }

        // Imposta l'intestazione con il nome della casa
        document.getElementById('house-name').innerText = data.house_name;

    } catch (error) {
        console.error('Error:', error);
    }
});
