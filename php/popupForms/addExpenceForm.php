        <div id="popupForm" class="popup">
            <div class="popup-content">
                <h2 class="popup-title">New Expense</h2>
                <br>
                <span class="close-btn"></span>
                <form id="formData">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" required>

                    <label for="user">user:</label>
                    <select name="user" id="user">
                        <!-- Options will be populated dynamically -->
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
                    <button type="submit">Sends</button>
                </form>
            </div>
        </div>