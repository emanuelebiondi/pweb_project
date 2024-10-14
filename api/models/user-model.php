
<?php
    //require_once '..\config\database.php'; // Include la connessione al database

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


        public function userHouse($data) {
            global $conn;
            $query = "
                SELECT  U.id = house_id,H.name as house_name
                FROM
                    users U
                    left join
                    houses H on U.house_id = H.id 
                WHERE U.id = ?";
            
            $stmt = $conn->prepare($query); // Prepare statement 
            if ($stmt === false) 
                die('Error in query preparation ' . $conn->error);

            $stmt->bind_param('ss', $data['id']); // Bind parameters
            
            return $stmt->execute();
        }

        // Aggiorna un utente esistente
        public function updateUser($data) {
            // Assicurarsi che l'user_id sia presente nell'array $data
            if (!isset($data['user_id'])) {
                return ['success' => false, 'error' => 'user_id is required'];
            }
    
            // Estraiamo l'user_id e rimuoviamolo da $data perché non fa parte dei campi da aggiornare
            $userId = $SESSION['id'];
    
            // Costruire la clausola SET dinamicamente
            $setClause = '';
            $params = [];
            $types = '';  // Questo servirà per i tipi di dati per il bind_param
    
            foreach ($data as $key => $value) {
                $setClause .= "$key = ?, ";  // Segnaposto per ogni campo
                $params[] = $value;          // Aggiungere il valore
                $types .= $this->getType($value);  // Determinare il tipo di dato (i - intero, s - stringa, etc.)
            }
    
            $setClause = rtrim($setClause, ', ');  // Rimuovere l'ultima virgola
    
            // Query di aggiornamento
            $sql = "UPDATE users SET $setClause WHERE id = ?";
    
            // Preparare lo statement
            $stmt = $this->db->prepare($sql);
            if ($stmt === false) {
                return ['success' => false, 'error' => 'Error preparing statement'];
            }
    
            // Aggiungere l'user_id alla fine dei parametri per la clausola WHERE
            $params[] = $userId;
            $types .= 'i';  // Assumiamo che user_id sia sempre un intero
    
            // Bind dei parametri dinamici
            $stmt->bind_param($types, ...$params);  // Legare dinamicamente i parametri
    
            // Eseguire la query
            if ($stmt->execute()) {
                return ['success' => true];
            } else {
                return ['success' => false, 'error' => 'Error during update'];
            }
    
            $stmt->close();  // Chiudere lo statement
        }
    
        // Funzione per determinare il tipo di dato per il binding
        private function getType($var) {
            if (is_int($var)) {
                return 'i';  // Intero
            } elseif (is_float($var)) {
                return 'd';  // Double
            } elseif (is_string($var)) {
                return 's';  // Stringa
            } else {
                return 'b';  // Blob o altri tipi
            }
        }

        // Elimina un utente
        public function delete($id) {
            // TODO
            // $sql = "DELETE FROM user WHERE id=$id";
        }
    }
?>