<!-- 
 Final Project for Web Design - University of Pisa 
 Professor: Alessio Vecchio
 Student: Emanuele Biondi
 January 2025 
-->

<?php
    // Start the session
    if (!isset($_SESSION)) session_start(); 

    // Check if exist the session, so redirect to dashboard
    if (isset($_SESSION['id'])) {
        header('Location: home.php');
        exit();
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>Cohabitat - Login</title>
    <link rel="stylesheet" href="../css/login-register.css" />
    <?php include "snippet/head-meta.html"?>
</head>
<body>
    <main class="container">
        <h1> Cohabitat <span class="special">Login</span></h1>
        
        <form id="loginform">
            <div class="form-control">
                <input type="email" id="email" name="email" placeholder=" "  required autocomplete="on">
                <label for="email"> Email </label>
            </div>

            <div class="form-control">
                <input type="password" id="password" name="password" placeholder=" " required autocomplete="on">
                <label for="password"> Password </label>
            </div>

            <input class="btn" type="submit" value="Send">

            <p class="errormsg" id="errorMessage"></p>
        </form>
        
        <p class="elseregister">If you are not registered, <a href="register.php">signup here!</a></p>
    </main>
    <script src="../js/login.js"></script>
</body>
<?php include "snippet/footer.html"?>
</html>

