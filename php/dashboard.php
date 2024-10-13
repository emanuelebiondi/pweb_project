<?php

    // Set the current page name
    $page_name = basename($_SERVER['PHP_SELF'], '.php');   
    include "snippet/header.php";
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/boxicons.css" >
    <link rel="stylesheet" href="../css/style.css">
    <title>Cohabitant - Dashboard</title>
</head>

<body>

    <!-- Header + topbar inserted by snippet/header.php -->
    
        <main>
            <div class="header">
                <div class="left">
                    <h1>Dashboard</h1>
                </div>
            </div>

            <div class="top-data">
                <!-- Insights -->
                <ul class="insights">
                    <li>
                        <i class='bx bx-calendar-check'></i>
                        <span class="info">
                            <h3>1000,00 €</h3>
                            <p>This Month</p>
                        </span>
                    </li>
                    <li><i class='bx bx-show-alt'></i>
                        <span class="info">
                            <h3>500,00€</h3>
                            <p>This Week</p>
                        </span>
                    </li>
                    <li><i class='bx bx-show-alt'></i>
                        <span class="info">
                            <h3>5000,00€</h3>
                            <p>This Year</p>
                        </span>
                    </li>
                </ul>
                <!-- End of Insights -->

                <!-- Payments Status -->
                <div class="payments-status">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>User Payments Status</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><p>John Doe</p></td>
                                <td><span class="status send">+20€</span></td>
                            </tr>
                            <tr>
                                <td><p>Pinco Palla</p></td>
                                <td><span class="status recive">-200,00€</span></td>
                            </tr>
                            <tr>
                                <td><p>Emanuele Biondi</p></td>
                                <td><span class="status send">+20€</span></td>
                            </tr>
                            <tr>
                                <td><p>John Doe</p></td>
                                <td><span class="status recive">-200,00€</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- End of Payments Status -->

            </div>

            <div class="bottom-data">
                <div class="payments last">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Recent Payments</h3>
                        <i class='bx bx-filter'></i>
                        <i class='bx bx-search'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Desc</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><p>John Doe</p></td>
                                <td>Sapone Piatti</td>
                                <td>200,00€</td>

                            </tr>
                            <tr>
                                <td><p>John Doe</p></td>
                                <td>Bolletta Enel</td>
                                <td>200,00€</td>

                            </tr>
                            <tr>
                                <td><p>John Doe</p></td>
                                <td>Tovaglia</td>
                                <td>200,00€</td>

                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Reminders -->
                <div class="reminders">
                    <div class="header">
                        <i class='bx bx-note'></i>
                        <h3>Remiders</h3>
                        <i class='bx bx-filter'></i>
                        <i class='bx bx-plus'></i>
                    </div>
                    <ul class="task-list">
                        <li class="completed">
                            <div class="task-title">
                                <i class='bx bx-check-circle'></i>
                                <p>Start Our Meeting</p>
                            </div>
                            <i class='bx bx-dots-vertical-rounded'></i>
                        </li>
                        <li class="completed">
                            <div class="task-title">
                                <i class='bx bx-check-circle'></i>
                                <p>Analyse Our Site</p>
                            </div>
                            <i class='bx bx-dots-vertical-rounded'></i>
                        </li>
                        <li class="not-completed">
                            <div class="task-title">
                                <i class='bx bx-x-circle'></i>
                                <p>Play Footbal</p>
                            </div>
                            <i class='bx bx-dots-vertical-rounded'></i>
                        </li>
                    </ul>
                </div>

                <!-- End of Reminders-->

            </div>

        </main>

    </div>

    <script src="index.js"></script>
</body>

</html>