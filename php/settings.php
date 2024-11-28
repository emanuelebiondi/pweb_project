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
    <title>Cohabitat - Settings</title>
</head>

<body>
    <!-- Header + topbar inserted by snippet/header.php -->
    <?php include "snippet/header.php"?>
        <main>
            <div class="header">
                <div class="left">
                    <h1>Settings</h1>
                </div>


            <div class="bottom-data">

                <!-- Reminders -->
                <div class="settings">

                <div class="header">
                        <h3>Password Change</h3>
                    </div>

                    <div class="password-form">
                        
                        <label for="old_password">Insert the old password: </label>
                        <input type="password" id="old_password" name="old_password">
                        <p id="formDataError"></p>
                        
                        <label for="new_password1">Insert the new password: </label>
                        <input type="password" id="new_password1" name="new_password1">
                        <p id="formDataError"></p>

                        <label for="new_password2">Reinsert the new password: </label>
                        <input type="password" id="new_password2" name="new_password2">
                        <p id="formDataError"></p>
                        
                    </div>
                    <div class="password-button">
                        <button type="submit">Send</button>
                    </div>
                    
                </div>
                </div>

                <!-- End of Reminders-->
            </div>

            <!-- Popup Create or Join in House (Hidden by default)-->
            <?php include_once 'popupForms/houseJoinForm.php' ?>

        </main>
    </div>

    <script src="../js/houseChoiceDashboard.js"></script>
</body>



</html>