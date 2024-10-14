
<?php
    require_once '..\config\database.php'; // Include la connessione al database

    class UserModel {

        // Ottieni tutti gli user
        public function fetchAll() {
            // TODO
            // $sql = "SELECT * FROM user";
        }

        // Ottieni un utente per ID
        public function fetchById($id) {
            //TODO
            // $sql = "SELECT * FROM user WHERE id = $id";

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
            // TODO
            // $sql = "UPDATE user SET name='$name', email='$email' WHERE id=$id";
        }

        // Elimina un utente
        public function delete($id) {
            // TODO
            // $sql = "DELETE FROM user WHERE id=$id";
        }
    }
?>