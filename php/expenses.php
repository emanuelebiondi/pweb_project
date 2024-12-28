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
    <title>Cohabitat - Expenses</title>
</head>

<body>
    <!-- Header + topbar inserted by snippet/header.php -->
    <?php include "snippet/header.php"?>
        <main>
            <div class="header">
                <div class="left">
                    
                    <h1>Expenses</h1>
                </div>
            </div>

            <div class="bottom-data">
                <div class="payments all">
                    <div class="header">
                        <h3>All Expenses</h3>
                        <button id="openPopupBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M19 11h-6V5h-2v6H5v2h6v6h2v-6h6z"/></svg>
                        </button>
                        
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>From</th>
                                <th>Category</th>
                                <th>Desc</th>
                                <th>Amount</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- php/expenses.php:(loadExpenses) -->

                        </tbody>
                    </table>
                    <div class="pagination">
                        <!-- php/expenses.php:(updatePagination) -->
                    </div>
                </div>

                <!-- User Expense -->
                <div class="user-expense">
                    <div class="header">
                        <i class='bx bx-money-withdraw'></i>
                        <h3>Total Expenditure</h3>
                    </div>
                    <ul class="user-list">
                    </ul>
                </div>

                <!-- End of User Expense-->
            </div>
        </main>
        <!-- Popup Add Payment (Hidden by default)-->
        <?php include_once 'popupForms/expenseForm.php'; ?>

    <script src="../js/expenses.js"></script>
</body>


</html>