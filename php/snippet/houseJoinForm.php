

<div id="popupForm" class="popup">
    <div class="popup-content">
        <h2>Create or Join in House</h2>
        <br>
        <span class="close-btn"></span>
        <form id="formData">
            <label for="date">Date:</label>
            <input type="date" id="date" name="dates" required>

            <label for="user">user:</label>
            <select name="user" id="user">
                <option value="1">Emanuele Biondi</option>
                <option value="2">John Doe</option>
                <option value="3">Jane Smith</option>
            </select>

            <label for="category">Category:</label>
            <select name="category" id="category">
                <option value="Tasse">Tasse</option>
                <option value="Bollette">Bollette</option>
                <option value="Detersivi">Detersivi</option>
                <option value="Altro">Altro</option>
            </select>

            <label for="desc">Description:</label>
            <input type="text" id="desc" name="desc" required>

            <label for="desc">Amount:</label>
            <input type="number" id="amount" name="amount" min="0" step="0.01" placeholder="0.00">

            <br>
            <button type="submit">Invia</button>
        </form>
    </div>
</div>
