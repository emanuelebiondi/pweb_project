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
    <?php include "snippet/head-meta.html"?>
    <title>Cohabitat - Payments</title>
</head>

<body>
    <!-- Header + topbar inserted by snippet/header.php -->
    <?php include "./snippet/header.php"?>
        <main>
            <div class="header">
                <div class="left">
                    <h1>Payments</h1>
                </div>
            </div>

            <div class="bottom-data">
                <div class="payments all">
                    <div class="header">
                        <h3>All Payments</h3>
                        <button id="openPopupBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"/></svg>
                        </button>
                        
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Method</th>
                                <th>Amount</th>
                                <th></th>
                                <th></th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <!-- php/payments.php:(loadExpenses) -->

                        </tbody>
                    </table>
                    <div class="pagination">
                        <!-- php/payments.php:(updatePagination) -->
                    </div>
                </div>

                <!-- Settle Up -->
                <div class="settle-up">
                    <div class="header">
                        <h3>Settle Up</h3>
                    </div>
                    <ul class="settleup-list">
                        <!-- php/payments.php:(loadSettleUp) -->
                    </ul>
                </div>

                <!-- End of Settle Up-->
            </div>

        </main>
        <!-- Popup Add Payment (Hidden by default)-->
        <?php include_once 'popupForms/paymentForm.php'; ?>

    <script src="../js/payments.js"></script>
</body>

</html>