
<?php

    $regex_email = "/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/";
    /*$regex_password = "/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/"; */
    
    $error = ""; 

    // Check the submit request and form data
    if (isset($_POST['login']) && 
        isset($_POST['email']) && 
        isset($_POST['password'])
    ){

        $usr_email = $_POST['email'];
        $usr_password = $_POST['password'];

        // Check if the form data is valid
        if (preg_match($regex_email, $usr_email)){
            
            require "../config/database.php"; // Check and Connect to DB     

            // Prepare statement to prevent SQL injection
            $query = "SELECT * FROM users WHERE email = ?;";
            if ($statement = mysqli_prepare($connection, $query)) {
                mysqli_stmt_bind_param($statement, 's', $usr_email);    // Bind the user with the query statement
                mysqli_stmt_execute($statement);

                $result = mysqli_stmt_get_result($statement);
                
                // Return in no mach email is present
                if (mysqli_num_rows($result) === 0) { $error = "There is no user with this email."; }
                else {
                    $row = mysqli_fetch_assoc($result);
                    $hash = $row['password'];
                    
                    if(password_verify($usr_password, $hash)){
                        session_start();
                        // Set session's variable
                        $_SESSION["id"] = $row['id'];
                        $_SESSION["email"] = $row['email'];
                        $_SESSION["name"] = $row['name'];
                        $_SESSION["surname"] = $row['surname'];
                        header("location: index.php");
                        exit();
                    }
                    else { $error = "Wrong password!";}
                }
                // Closing statement and connection
                mysqli_stmt_close($statement);
                mysqli_close($connection);
            }
            else { die(mysqli_connect_error());}
        }
    }
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Cohabitat</title>
    <link rel="stylesheet" href="../css/login.css" />
</head>
<body>
    <main class="container">
        <h1> Cohabitat <span class="special">Login</span></h1>
        <form id="loginform" action="login.php" method="POST">
            <div class="form-control">
                <input type="email" id="email" name="email" placeholder=" " require pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}">
                <label for="email"> Email </label>
            </div>
            <div class="form-control">
                <input type="password" id="password" name="password" placeholder=" ">
                <label for="password"> Password </label>
            </div>
            <input class="btn" type="submit" value="Send" name="login">
            
            <p class="errormsg"> <?php if (!empty($error)) echo $error; # // In case of error, display the message ?> </p>
        </form>
        <p class="elseregister">If you are not registered, <a href="register.php">sign up here!</a></p>
    </main>
</body>
<?php include "footer.html"?>
</html>






<!-- Speigazione della regedix della password (l'email è piu semplice):
    (?=.*[A-Z]): almeno una lettera maiuscola.
    (?=.*[0-9]): almeno un numero.
    (?=.*[!@#$%^&*]): almeno un carattere speciale (puoi personalizzare la lista di caratteri speciali se necessario).
    [A-Za-z\d!@#$%^&*]{8,}: la password può contenere lettere maiuscole, minuscole, numeri e caratteri speciali, con una lunghezza minima di 8 caratteri.
-->