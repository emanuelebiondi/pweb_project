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
    <title>Cohabitat - Reminders</title>
</head>

<body>
    <!-- Header + topbar inserted by snippet/header.php -->
    <?php include "snippet/header.php"?>
        <main>
            <div class="header">
                <div class="left">
                    <h1>Reminders</h1>
                </div>


            <div class="bottom-data">

                <!-- Reminders -->
                <div class="reminders">

                    <ul class="task-list" id="task-list">
                        <!-- Task elements will be dynamically added here -->
                        <li class="task-new" id="task-new">
                            <button>+</button>
                        </li>

                    </ul>
                </div>

                <!-- End of Reminders-->
            </div>

            <!-- Popup Create or Join in House (Hidden by default)-->
            <?php include_once 'popupForms/houseJoinForm.php' ?>

        </main>
    </div>

    <script src="../js/reminder.js"></script>
    <script src="../js/houseChoiceDashboard.js"></script>
</body>



</html>