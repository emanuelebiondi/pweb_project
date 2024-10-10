<?php
    // Now we check if the data from the login form was submitted, isset() will check if the data exists.
    if ( !isset($_POST['username'], $_POST['password']) ) {
        // Could not get the data that should have been sent.
        exit('Please fill both the username and password fields!');
    }

    // Prepare our SQL, preparing the SQL statement will prevent SQL injection.
    if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
        // Bind parameters (s = string, i = int, b = blob, etc), in our case the username is a string so we use "s"
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        // Store the result so we can check if the account exists in the database.
        $stmt->store_result();


        $stmt->close();
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
        <form>
            <div class="form-control">
                <input type="email" id="email" placeholder=" " required>
                
                <label for="email"> Email </label>
            </div>
            <div class="form-control">
                <input type="password" id="password" placeholder=" " required>
                <label for="password"> Password </label>
            </div>
            <button class="btn"> Submit </button>
        </form>
        <p class="elseregister">If you are not registered, <a href="register.php">sign up here!</a></p>
    </main>
    
</body>
</html>