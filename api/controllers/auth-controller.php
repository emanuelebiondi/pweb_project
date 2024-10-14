<?php

class AuthController {
    public function register() {
        header('Content-Type: application/json');
    
        // Regex per la validazione
        $regex_email = "/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/";
        $regex_password = "/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/"; 
        $regex_name = "/^[A-Za-z]{2,12}$/";
        $regex_surname = "/^[A-Za-z]{2,12}$/";
    
        // Ricevi i dati dalla richiesta
        $data = json_decode(file_get_contents("php://input"), true);
        $usr_email = strtolower($data['email']);
        $usr_name = ucfirst(strtolower($data['name']));
        $usr_surname = ucfirst(strtolower($data['surname']));
        $usr_password1 = $data['password1'];
        $usr_password2 = $data['password2'];
    
        try {
            // Validazione dei dati
            if (!preg_match($regex_email, $usr_email) || !preg_match($regex_name, $usr_name) || 
                !preg_match($regex_surname, $usr_surname) || !preg_match($regex_password, $usr_password1)) {
                throw new Exception('Check the inputs format');
            }
    
            // Controllo delle password
            if (strcmp($usr_password1, $usr_password2) !== 0) { 
                throw new Exception('The passwords do not match');
            }
    
            // Connessione al database
            require "../config/database.php"; 
    
            if (!$connection) {
                throw new Exception('Database connection error');
            }
    
            // Prepara la query per prevenire SQL injection
            $query = "SELECT * FROM users WHERE email = ?";
            if ($statement = mysqli_prepare($connection, $query)) {
                mysqli_stmt_bind_param($statement, 's', $usr_email);
                mysqli_stmt_execute($statement);
                $result = mysqli_stmt_get_result($statement); 
    
                // Controlla se l'email è già registrata
                if (mysqli_num_rows($result) !== 0) { 
                    throw new Exception('Email already registered');
                }
    
                // Inserisce il nuovo utente nel database
                $query = "INSERT INTO users (email, password, name, surname) VALUES (?, ?, ?, ?)";
                if ($statement = mysqli_prepare($connection, $query)) {
                    $password = password_hash($usr_password1, PASSWORD_BCRYPT);
                    mysqli_stmt_bind_param($statement, 'ssss', $usr_email, $password, $usr_name, $usr_surname);
                    if (mysqli_stmt_execute($statement)) {
                        echo json_encode(['success' => 'User registered successfully']);
                    } else {
                        throw new Exception('Query execution error: ' . mysqli_error($connection));
                    }
                } else {
                    throw new Exception('Database query preparation error');
                }
    
                mysqli_stmt_close($statement);
            } else {
                throw new Exception('Database connection error');
            }
    
        } catch (Exception $e) {
            // Gestione degli errori
            echo json_encode(['error' => $e->getMessage()]);
        } finally {
            // Chiudi la connessione al database
            if (isset($connection)) {
                mysqli_close($connection); 
            }
        }
    }

}
