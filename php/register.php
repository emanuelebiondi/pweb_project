<!-- 
 Final Project for Web Design - University of Pisa 
 Professor: Alessio Vecchio
 Student: Emanuele Biondi
 January 2025 
-->

<?php
    // Start the session
    session_start(); 
    
    // Check if exist the session, so redirect to dashboard
    if (isset($_SESSION['id'])) {
        header('Location: home.php');
        exit();
    }
?>



    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Cohabitat - Register</title>
        <link rel="stylesheet" href="../css/login-register.css" />
        <?php include "snippet/head-meta.html"?>
    </head>
    <body class="register-page">
        <main class="container">
            <h1> Cohabitat <span class="special">Register</span></h1>
            
            <form id="registerForm">  
                <div class="form-control">
                    <input type="email" id="email" name="email" placeholder=" " required pattern="[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z]{2,}">
                    <label for="email"> Email </label>
                </div>
    
                <div class="form-control">
                    <input type="text" id="name" name="name" placeholder=" " required pattern="[A-Za-z]{2,12}">
                    <label for="name"> Name </label>
                </div>
                
                <div class="form-control">
                    <input type="text" id="surname" name="surname" placeholder=" " required pattern="[A-Za-z]{2,12}">
                    <label for="surname"> Surname </label>
                </div>
                
                <div class="form-control">
                    <input type="password" id="password1" name="password1" placeholder=" " required pattern="(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}">
                    <label for="password1"> Password </label>
                    <p>Must be at least 8 characters, with one uppercase letter, one number, and one special character.</p> 
                </div>
                
                <div class="form-control">
                    <input type="password" id="password2" name="password2" placeholder=" " required>
                    <label for="password2"> Repeat Password </label>
                </div>
                
                <input class="btn" type="submit" value="Send">
                <p class="errormsg" id="errorMessage"></p>
            </form>
            <p class="elseregister">If you are already registered, <a href="login.php">login here!</a></p>
        </main>
    
        <script src="../js/register.js"></script>

    </body>
    <?php include "snippet/footer.html"?>
    </html>
    