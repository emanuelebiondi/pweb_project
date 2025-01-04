<!-- Popup Create or Join in House (included in Dashboard.php)-->
<div id="popupFormJoinHouse" class="popup">
  <div class="popup-content">

    <br>

    <form id="formData">
      <h2>Join a House</h2>
      <label for="house_code">Insert the code: </label>
      <input type="text" id="house_code" name="house_code">
      <p id="formDataError"></p>

      <br>
      <h2>OR</h2>
      <br>

      <h2>Create a House</h2>
      <label for="house_name">Enter the house name:</label>
      <input type="text" id="house_name" name="house_name" maxlength="30">

      <br>
      <button type="submit">Send</button>
    </form>
  </div>
</div>