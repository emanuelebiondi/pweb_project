
<?php
    class UserModel {

        // Ottieni tutti gli user
        public function fetchAll($house_id) {
            global $conn;
            
            $query = "
                SELECT id, name, surname
                FROM users 
                WHERE house_id = ?";
            
            $stmt = $conn->prepare($query); // Prepare statement 
            if ($stmt === false) 
                die('Error in query preparation ' . $conn->error);

            $stmt->bind_param('i', $house_id); // Bind parameters
            
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        // Ottieni un utente attraverso l' ID
        public function fetchById($id) {
            global $conn;
            $sql = "
                SELECT U.id, U.name, U.surname, U.email, U.house_id, H.name as house_name 
                FROM users U
                    left join houses H on U.house_id = H.id 
                WHERE U.id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) die('Error in query preparation ' . $conn->error);
    
            $stmt->bind_param('i', $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
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
        

        
        // Ottini la casa di un utente
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
        public function update($data) {
            global $conn;
        
            // Verificare che la sessione contenga l'user_id
            if (!isset($_SESSION['id'])) {
                return false;  // Se l'user_id non è presente, restituisce false
            }
        
            $userId = $_SESSION['id'];  // Recupera l'user_id dalla sessione
        
            // Costruire la clausola SET dinamicamente con i dati della richiesta
            // ATTENZIONE! ATTENZIONE!
            // Qui bisogna controllare che i parametri della richiesta siano effettivamente validi
            // per evitare SQL injection. Mentre i valori vengono validati piu avanti da mysqli tramite bind_param...

            $allowedColumns = ['house_id', 'joinedAt', 'password', 'name', 'surname']; // Colonne valide
            $setClause = '';
            $params = [];
            $types = '';
            
            foreach ($data as $key => $value) {
                if (!in_array($key, $allowedColumns)) {
                    throw new Exception("Invalid column name: $key");
                }
                $setClause .= "$key = ?, ";
                $params[] = $value;
                $types .= $this->getType($value);   // GetType determia il tipo di dato (lookdown the code)
            }
        
            $setClause = rtrim($setClause, ', ');  // Rimuovere l'ultima virgola inserita dal ciclo
        
            // Query di aggiornamento
            $sql = "UPDATE users SET $setClause WHERE id = ?";
            
            // Preparare lo statement
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                return false;  // false in caso di errore nella preparazione dello statement
            }
        
            // Aggiungere l'user_id alla fine dei parametri per la clausola WHERE
            $params[] = $userId;  // Aggiungere l'user_id preso dalla sessione
            $types .= 'i';  // Assumo che user_id sia sempre un intero
        
            // Bind dei parametri dinamici
            $stmt->bind_param($types, ...$params); 
        
            // Eseguire la query
            if ($stmt->execute()) {
                $stmt->close();  // Chiudere lo statement
                return $userId;  // user_id al successo
            } else {
                $stmt->close();  // Chiudere lo statement
                return false;  // false in caso di errore durante l'update
            }
        }
    
        // Funzione per determinare il tipo di dato per il binding
        // (necessario per il bind_param di mysqli con il sistema dinamico sopra)
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

    }
?>