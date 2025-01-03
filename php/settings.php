<?php
// Set the current page name
$page_name = basename($_SERVER['PHP_SELF'], '.php');
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/style.css">
  <?php include "snippet/head-meta.html" ?>
  <title>Cohabitat - Settings</title>
</head>

<body>
  <!-- Header + topbar inserted by snippet/header.php -->
  <?php include "snippet/header.php" ?>
  <main>
    <div class="header">
      <div class="left">
        <h1>Settings</h1>
      </div>
    </div>

    <div class="bottom-data">

      <!-- Settings -->
      <div class="settings">
        <div class="header">
          <h3>Password Change</h3>
        </div>

        <div class="password-form">
          <label for="old_password">Insert the old password: </label>
          <input type="password" id="old_password" name="old_password">

          <label for="new_password1">Insert the new password: </label>
          <input type="password" id="new_password1" name="new_password1">

          <label for="new_password2">Reinsert the new password: </label>
          <input type="password" id="new_password2" name="new_password2">
          <p id="message"></p>
        </div>
        <div class="password-button">
          <button type="submit" id="changePasswordBtn">Change</button>
        </div>
      </div>
      <!-- End of Settings-->

      <!-- Categories -->
      <div class="categories">
        <div class="header">
          <h3>Manage Expense Category</h3>
          <div class="addCategoryBtn">
            <button type="submit" id="addCategoryBtn">+</button>
          </div>
        </div>

        <div class="category-space" id="categorySpace">
          <!-- Categories will be populated dynamically -->
        </div>
      </div>
      <!-- End of Categories-->
    </div>

    <!-- Popup Create or Join in House (Hidden by default)-->
    <?php include_once 'popupForms/houseJoinForm.php' ?>

  </main>
  </div>

  <script src="../js/houseChoiceDashboard.js"></script>
  <script src="../js/settings.js"></script>

</body>


</html>