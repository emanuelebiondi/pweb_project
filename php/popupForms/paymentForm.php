        <div id="popupForm" class="popup">
            <div class="popup-content">
                <h2 class="popup-title">New Payment</h2>
                <br>
                <span class="close-btn"></span>
                <form id="formData">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" required>

                    <label for="user_from">From:</label>
                    <select name="user_from" id="user_from" required>
                        <!-- Options will be populated dynamically -->
                        
                    </select>

                    <label for="user_to">To:</label>
                    <select name="user_to" id="user_to" required>
                        <!-- Options will be populated dynamically -->
                        
                    </select>

                    <label for="method">Method:</label>
                    <select name="method" id="method" required>
                        <option value="" disabled selected>Select an option</option>
                        <option value="Cash">Cash</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="PayPal">PayPal</option>
                        <option value="Satispay">Satispay</option>
                        <option value="Cryptocurrency">Cryptocurrency</option>
                        <option value="Prepaid Card">Prepaid Card</option>
                        <option value="Other">Other</option>
                    </select>


                    <label for="amount">Amount:</label>
                    <input type="number" id="amount" name="amount" min="0" step="0.01" placeholder="0.00" required>

                    <br>
                    <button type="submit">Sends</button>
                </form>
            </div>
        </div>