<!-- 
 Final Project for Web Design - University of Pisa 
 Professor: Alessio Vecchio
 Student: Emanuele Biondi
 January 2025 
-->

<?php
    $regex_email = "/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/";
    /*$regex_password = "/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/"; */
    
    $error = ""; 

    // Check the submit request and form data
    if (isset($_POST['login']) && 
        isset($_POST['email']) && 
        isset($_POST['password'])
    ){
        $usr_email = strtolower($_POST['email']);
        $usr_password = $_POST['password'];
        
        try {
            // Check input format 
            if (!preg_match($regex_email, $usr_email)){
                throw new Exception("Check the inputs format");
            }
            
            require "../config/database.php"; // Check and Connect to DB     

            // Prepare statement to prevent SQL injection
            $query = "SELECT * FROM users WHERE email = ?;";

            if ($statement = mysqli_prepare($connection, $query)) {
                mysqli_stmt_bind_param($statement, 's', $usr_email);    // Bind the user with the query statement
                mysqli_stmt_execute($statement);

                $result = mysqli_stmt_get_result($statement);

                // Return if no mach email is present
                if (mysqli_num_rows($result) === 0) { 
                    throw new Exception("There is no user with this email."); 
                }

                $row = mysqli_fetch_assoc($result);
                $hash = $row['password'];
                
                // Check the password
                if(!password_verify($usr_password, $hash)){
                    throw new Exception("Wrong password!");
                }

                session_start();
                // Set session's variable
                $_SESSION["id"] = $row['id'];
                $_SESSION["email"] = $row['email'];
                $_SESSION["name"] = $row['name'];
                $_SESSION["surname"] = $row['surname'];
                header("location: dashboard.php");

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
    <title>Cohabitat - Login</title>
    <link rel="stylesheet" href="../css/login-register.css" />
    <?php include "snippet/head-meta.html"?>
</head>
<body>
    <main class="container">
        <h1> Cohabitat <span class="special">Login</span></h1>
        <form id="loginform" action="login.php" method="POST">
            <div class="form-control">
                <input type="email" id="email" name="email" placeholder=" " required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}">
                <label for="email"> Email </label>
            </div>
            <div class="form-control">
                <input type="password" id="password" name="password" placeholder=" " required>
                <label for="password"> Password </label>
            </div>
            <input class="btn" type="submit" value="Send" name="login">
            
            <p class="errormsg"> <?php if (!empty($error)) echo $error; # // In case of error, display the message ?> </p>
        </form>
        <p class="elseregister">If you are not registered, <a href="register.php">sign up here!</a></p>
    </main>
</body>
<?php include "snippet/footer.html"?>
</html>






<!-- Speigazione della regedix della password (l'email è piu semplice):
    (?=.*[A-Z]): almeno una lettera maiuscola.
    (?=.*[0-9]): almeno un numero.
    (?=.*[!@#$%^&*]): almeno un carattere speciale (puoi personalizzare la lista di caratteri speciali se necessario).
    [A-Za-z\d!@#$%^&*]{8,}: la password può contenere lettere maiuscole, minuscole, numeri e caratteri speciali, con una lunghezza minima di 8 caratteri.
-->