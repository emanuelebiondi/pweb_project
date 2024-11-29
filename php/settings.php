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
                        <p id="formDataError"></p>
                        
                        <label for="new_password1">Insert the new password: </label>
                        <input type="password" id="new_password1" name="new_password1">
                        <p id="formDataError"></p>

                        <label for="new_password2">Reinsert the new password: </label>
                        <input type="password" id="new_password2" name="new_password2">
                        <p id="formDataError"></p>
                        
                    </div>
                    <div class="password-button">
                        <button type="submit" id="changePassword">Send</button>
                    </div>
                </div>
                <!-- End of Settings-->

                <!-- Categories -->
                <div class="categories">
                    <div class="header">
                        <h3>Manage Expense Category</h3>
                        <div class="password-button">
                            <button type="submit" id="addCategoryBtn">+</button>
                        </div>
                    </div>

                    <div class="category-space" id="categorySpace">
                        <div class="category-element">
                            <textarea maxlength="20"></textarea>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" onclick="deleteExpense(${expense.id}, '${expense.date}', '${expense.descr}', ${expense.amount})">
                                <path fill="currentColor" d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"/>
                                <path fill="currentColor" d="M9 10h2v8H9zm4 0h2v8h-2z"/>
                            </svg>
                        </div>
                        


                        
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