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
    <title>Cohabitant - Payments</title>
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.7rem" height="1.7rem" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2m0 18a8 8 0 1 1 8-8a8 8 0 0 1-8 8"/><path fill="currentColor" d="M12 11c-2 0-2-.63-2-1s.7-1 2-1s1.39.64 1.4 1h2A3 3 0 0 0 13 7.12V6h-2v1.09C9 7.42 8 8.71 8 10c0 1.12.52 3 4 3c2 0 2 .68 2 1s-.62 1-2 1c-1.84 0-2-.86-2-1H8c0 .92.66 2.55 3 2.92V18h2v-1.08c2-.34 3-1.63 3-2.92c0-1.12-.52-3-4-3"/></svg>
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M12 15c-1.84 0-2-.86-2-1H8c0 .92.66 2.55 3 2.92V18h2v-1.08c2-.34 3-1.63 3-2.92c0-1.12-.52-3-4-3c-2 0-2-.63-2-1s.7-1 2-1s1.39.64 1.4 1h2A3 3 0 0 0 13 7.12V6h-2v1.09C9 7.42 8 8.71 8 10c0 1.12.52 3 4 3c2 0 2 .68 2 1s-.62 1-2 1"/><path fill="currentColor" d="M5 2H2v2h2v17a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V4h2V2zm13 18H6V4h12z"/></svg>
                        
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