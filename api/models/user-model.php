
<?php
    require_once 'database.php'; // Include la connessione al database

    class UserModel {

        // Ottieni tutti gli user
        public function fetchAll() {
            global $conn;
            $sql = "SELECT * FROM user";
            $result = $conn->query($sql);
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        // Ottieni un utente per ID
        public function fetchById($id) {
            global $conn;
            $sql = "SELECT * FROM user WHERE id = $id";
            $result = $conn->query($sql);
            return $result->fetch_assoc();
        }

        // Crea un nuovo utente
        public function create($data) {
            global $conn;
            $sql = "INSERT INTO users (email, name, surname, password) VALUES (?, ?, ?, ?)";
            
            $stmt = $conn->prepare($sql); // Prepare statement 
            if ($stmt === false) 
                die('Error in query preparation ' . $conn->error);

            $stmt->bind_param('ss', $data['email'], $data['name'], $data['surname'], $data['password']); // Bind parameters
            
            return $stmt->execute();
        }

        // Aggiorna un utente esistente
        public function update($data) {
            global $conn;
            $id = intval($data['id']);
            $name = $conn->real_escape_string($data['name']);
            $email = $conn->real_escape_string($data['email']);
            $sql = "UPDATE user SET name='$name', email='$email' WHERE id=$id";
            return $conn->query($sql);
        }

        // Elimina un utente
        public function delete($id) {
            global $conn;
            $sql = "DELETE FROM user WHERE id=$id";
            return $conn->query($sql);
        }
    }
?>