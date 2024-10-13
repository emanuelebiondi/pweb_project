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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/style.css">
    <title>Cohabitant - Dashboard</title>
    <script> 
        function openForm() {
            document.getElementById("myForm").style.display = "block";
            }

            function closeForm() {
            document.getElementById("myForm").style.display = "none";
            }
    </script>
</head>

<body>

    <!-- Header + topbar inserted by snippet/header.php -->
    
        <main>
            <div class="header">
                <div class="left">
                    <h1>Expenses</h1>
                </div>
            </div>

            <div class="bottom-data">
                <div class="payments all">
                    <div class="header">
                        <i class='bx bx-cart-alt'></i>
                        <h3>All Expenses</h3>
                        <i class='bx bx-filter'></i>
                        <button id="openPopupBtn"><i class='bx bx-plus'></i></button>
                        
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Desc</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>18/08/2024</td>
                                <td><p>John Doe</p></td>
                                <td>Emanuele Biondi</td>
                                <td>Sapone Piatti</td>
                                <td>200,00€</td>
                                <td><i class='bx bx-edit'></i></td>
                                <td><i class='bx bx-trash'></i></td>
                            </tr>
                            <tr>
                                <td>18/08/2024</td>
                                <td><p>John Doe</p></td>
                                <td>Emanuele Biondi</td>
                                <td>Bolletta Enel + robe della casaa</td>
                                <td>200,00€</td>
                                 <td><i class='bx bx-edit'></i></td>
                                 <td><i class='bx bx-trash'></i></td>
                            </tr>
                            <tr>
                                <td>18/08/2024</td>
                                <td><p>John Doe</p></td>
                                <td>Emanuele Biondi</td>
                                <td>Tovaglia</td>
                                <td>200,00€</td>
                                 <td><i class='bx bx-edit'></i></td>
                                 <td><i class='bx bx-trash'></i></td>
                            </tr>
                            <tr>
                                <td>18/08/2024</td>
                                <td><p>John Doe</p></td>
                                <td>Emanuele Biondi</td>
                                <td>Sapone Piatti</td>
                                <td>200,00€</td>
                                 <td><i class='bx bx-edit'></i></td>
                                 <td><i class='bx bx-trash'></i></td>
                            </tr>
                            <tr>
                                <td>18/08/2024</td>
                                <td><p>John Doe</p></td>
                                <td>Emanuele Biondi</td>
                                <td>Bolletta Enel</td>
                                <td>200,00€</td>
                                <td><i class='bx bx-edit'></i></td>
                                <td><i class='bx bx-trash'></i></td>
                                <em></em>
                            </tr>
                            <tr>
                                <td>18/08/2024</td>
                                <td><p>John Doe</p></td>
                                <td>Emanuele Biondi</td>
                                <td>Tovaglia</td>
                                <td>200,00€</td>
                                 <td><i class='bx bx-edit'></i></td>
                                 <td><i class='bx bx-trash'></i></td>
                            </tr>
                            <tr>
                                <td>18/08/2024</td>
                                <td><p>John Doe</p></td>
                                <td>Emanuele Biondi</td>
                                <td>Sapone Piatti</td>
                                <td>200,00€</td>
                                 <td><i class='bx bx-edit'></i></td>
                                 <td><i class='bx bx-trash'></i></td>
                            </tr>
                            <tr>
                                <td>18/08/2024</td>
                                <td><p>John Doe</p></td>
                                <td>Emanuele Biondi</td>
                                <td>Bolletta Enel</td>
                                <td>200,00€</td>
                                 <td><i class='bx bx-edit'></i></td>
                                 <td><i class='bx bx-trash'></i></td>
                            </tr>
                            <tr>
                                <td>18/08/2024</td>
                                <td><p>John Doe</p></td>
                                <td>Emanuele Biondi</td>
                                <td>Tovaglia</td>
                                <td>200,00€</td>
                                 <td><i class='bx bx-edit'></i></td>
                                 <td><i class='bx bx-trash'></i></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="pagination">
                        <a href="#">&laquo;</a>
                        <a class="active" href="#">1</a>
                        <a href="#">2</a>
                        <a href="#">3</a>
                        <a href="#">4</a>
                        <a href="#">5</a>
                        <a href="#">6</a>
                        <a href="#">&raquo;</a>
                    </div>
                </div>

                <!-- User Expense -->
                <div class="user-expense">
                    <div class="header">
                        <i class='bx bx-money-withdraw'></i>
                        <h3>Total Expenditure</h3>
                        <i class='bx bx-filter'></i>
                    </div>
                    <ul class="user-list">
                        <li class="user">
                            <div class="circle">E</div>
                            <span class="name">Emanuele Biondi</span>
                            <span class="amount">200,00€</span>
                        </li>
                        <li class="user">
                            <div class="circle">J</div>
                            <span class="name">John Doe</span>
                            <span class="amount">150,00€</span>
                        </li>
                        <li class="user">
                            <div class="circle">J</div>
                            <span class="name">Jane Smith</span>
                            <span class="amount">300,00€</span>
                        </li>
                    </ul>
                </div>

                <!-- End of User Expense-->

            </div>
            <!-- Bottone per aprire il popup -->


        <!-- Popup Add Payment -->
        <div id="popupForm" class="popup">
            <div class="popup-content">
                <span class="close-btn">&times;</span> <!-- Bottone di chiusura -->
                <h2>Inserisci i tuoi dati</h2>
                <form id="formData">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="dates" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <button type="submit">Invia</button>
                </form>
            </div>
        </div>


        </main>

    </div>

    <script src="../js/script.js"></script>
</body>

</html>