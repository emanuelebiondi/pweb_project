<?php

    // Set the current page name
    $page_name = basename($_SERVER['PHP_SELF'], '.php');   
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/boxicons.css" >
    <link rel="stylesheet" href="../css/style.css">
    <title>Cohabitat - Dashboard</title>
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

                    <ul class="task-list">
                        <li class = "task-element">
                            <div class="task-text">
                                <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Blanditiis repellendus vitae, fuga praesentium totam explicabo dolores tempore obcaecati? Nam, et distinctio harum nulla laborum omnis adipisci temporibus aliquam? Eligendi, totam?</p>
                            </div>
                            <span>Delete</span>
                        </li>
                        <li class="task-new">
                            <p>+</p>
                        </li>

                    </ul>
                </div>

                <!-- End of Reminders-->
            </div>

            <!-- Popup Create or Join in House (Hidden by default)-->
            <?php include_once 'popupForms/houseJoinForm.php' ?>

        </main>
    </div>

    <script src="../js/dashboard.js"></script>
    <script src="../js/houseChoiceDashboard.js"></script>
</body>



</html>