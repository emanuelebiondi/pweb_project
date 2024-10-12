<!-- 
 Final Project for Web Design - University of Pisa 
 Professor: Alessio Vecchio
 Student: Emanuele Biondi
 January 2025 
-->

<?php
    $regex_email = "/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/";
    $regex_password = "/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/"; // Must be at least 8 characters, with one uppercase letter, one number, and one special character.
    $regex_name = "/^[A-Za-z]{2,12}$/";
    $regex_surname = "/^[A-Za-z]{2,12}$/";
    
    $error = ""; 


    // Check the submit request and form data
    if (isset($_POST['register']) && 
        isset($_POST['email']) && 
        isset($_POST['name']) && 
        isset($_POST['surname']) && 
        isset($_POST['password1']) &&
        isset($_POST['password2'])
    ){
        $usr_email = strtolower($_POST['email']);
        $usr_name = ucfirst(strtolower($_POST['name']));
        $usr_surname = ucfirst(strtolower($_POST['surname']));
        $usr_password1 = $_POST['password1'];
        $usr_password2 = $_POST['password2'];
        
        try {
            // Check input format 
            if (!preg_match($regex_email, $usr_email) && !preg_match($regex_name, $usr_name) && 
                !preg_match($regex_surname, $usr_surname) && !preg_match($regex_password, $usr_password1)) {
                    throw new Exception("Check the inputs format");
            }
            
            // Check if the two password metch
            if (strcmp($usr_password1, $usr_password2) !== 0) { 
                throw new Exception("The passwords do not match");
            }

            // Check and Connect to DB 
            require "../config/database.php"; 

            // Prepare statement to prevent SQL injection
            $query = "SELECT * FROM users WHERE email = ?;";

            if ($statement = mysqli_prepare($connection, $query)) {
                mysqli_stmt_bind_param($statement, 's', $usr_email);    // Bind the user with the query statement
                mysqli_stmt_execute($statement);
    
                $result = mysqli_stmt_get_result($statement); 
                
                // Check if extist an user with the same email
                if (mysqli_num_rows($result) !== 0) { 
                    throw new Exception("Email already registered");
                }

                // Insert new user in the databases
                $query = "INSERT INTO users (email, password, name, surname) values (?, ?, ?, ?)";

                if ($statement = mysqli_prepare($connection, $query)){
                    $password = password_hash($usr_password1, PASSWORD_BCRYPT);
                    mysqli_stmt_bind_param($statement, 'ssss', $usr_email, $password, $usr_name, $usr_surname);
                    mysqli_stmt_execute($statement);
                    header("location: login.php");
                }

                // Closing statement and connection
                mysqli_stmt_close($statement);
                mysqli_close($connection); 
            }
            else { die(mysqli_connect_error()); }       
        } 
        catch (Exception $e) {
            // Handle the exception
            $error = $e->getMessage();
        }
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
            
            <form action="register.php" method="POST">  
                <div class="form-control">
                    <input type="email" id="email" name="email" placeholder=" " autocomplete="email" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}">
                    <label for="email"> Email </label>
                </div>

                <div class="form-control">
                    <input type="text" id="name" name="name" placeholder=" " autocomplete="given-name" required pattern="[A-Za-z]{2,12}">
                    <label for="name"> Name </label>
                </div>
                
                <div class="form-control">
                    <input type="text" id="surname" name="surname" placeholder=" " autocomplete="family-name" required pattern="[A-Za-z]{2,12}">
                    <label for="surname"> Surname </label>
                </div>
                
                <div class="form-control">
                    <input type="password" id="password1" name="password1" placeholder=" " required pattern="(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}">
                    <label for="password1"> Password </label>
                    <p>Must be at least 8 characters, with one uppercase letter, one number, and one special character.</p> 
                    
                </div>
                
                <div class="form-control">
                    <input type="password" id="password2" name="password2" placeholder=" " required pattern="(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}">
                    
                    <label for="password2"> Repeat Password </label>
                </div>
                
                <input class="btn" type="submit" value="Send" name="register">
                <p class="errormsg"> <?php if (!empty($error)) echo $error; # // In case of error, display the message ?> </p>
            </form>
            <p class="elseregister">If you are already registered, <a href="login.php">log in here!</a></p>
        </main>
    </body>
    <?php include "snippet/footer.html"?>
</html>