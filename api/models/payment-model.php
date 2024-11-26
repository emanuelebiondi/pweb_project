<?php

class PaymentModel {

    // Fetch all payments
    public function fetchAll($house_id, $limit, $offset) {
        global $conn;
    
        // Query per ottenere sia le spese che il numero totale di record
        $query = "
        SELECT SQL_CALC_FOUND_ROWS P.id, P.date, P.id_user_to, P.id_user_from, P.payment_method, P.amount, 
            U2.name AS user_to_name, U2.surname AS user_to_surname, 
            U1.name AS user_from_name, U1.surname AS user_from_surname
        FROM payments P
            INNER JOIN users U1 ON P.id_user_from = U1.id
            INNER JOIN users U2 ON P.id_user_to = U2.id
        WHERE U1.house_id = ?
        ORDER BY P.date DESC
        LIMIT ? OFFSET ?;
        ";
    
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            http_response_code(500); // Return 500 Internal Server Error
            die('Error in query preparation ' . $conn->error);
        }
        
        $stmt->bind_param('iii', $house_id, $limit, $offset);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $data = [];
    
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    
        // Ottieni il numero totale di record dalla funzione FOUND_ROWS()
        /*  La funzione SELECT FOUND_ROWS() in MySQL restituisce il numero di righe che sarebbero state trovate 
            dalla query precedente senza considerare i limiti imposti da LIMIT e OFFSET. Viene utilizzata per 
            otottenere il numero totale di record che soddisfano una determinata condizione, prima dell'applicazione
            del limite di paginazione.*/
        $totalResult = $conn->query("SELECT FOUND_ROWS() as total");
        $totalRecords = $totalResult->fetch_assoc()['total'];
    
        // Calcola il numero totale di pagine
        $totalPages = ceil($totalRecords / $limit);
    
        return [
            'payments' => $data,
            'total_records' => $totalRecords,
            'current_page' => ($offset / $limit) + 1,
            'total_pages' => $totalPages,
        ];
    }

    public function getAll($house_id) {
        global $conn;
    
        // Query per ottenere sia le spese che il numero totale di record
        $query = "
            SELECT P.id, P.date, P.id_user_to, P.id_user_from, P.payment_method, P.amount, 
                U2.name AS user_to_name, U2.surname AS user_to_surname, 
                U1.name AS user_from_name, U1.surname AS user_from_surname
            FROM payments P
                INNER JOIN users U1 ON P.id_user_from = U1.id
                INNER JOIN users U2 ON P.id_user_to = U2.id
            WHERE U1.house_id = ?
        ";
    
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die('Error in query preparation ' . $conn->error);
        }
        
        $stmt->bind_param('i', $house_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }



    public function fetchTotalByTime($house_id, $filter) {
        global $conn;
    
        // Costruisci la parte WHERE basata sul filtro
        switch ($filter) {
            case 'week':
                $timeCondition = "WEEK(E.date) = WEEK(NOW()) AND YEAR(E.date) = YEAR(NOW())";
                break;
            case 'month':
                $timeCondition = "MONTH(E.date) = MONTH(NOW()) AND YEAR(E.date) = YEAR(NOW())";
                break;
            case 'year':
                $timeCondition = "YEAR(E.date) = YEAR(NOW())";
                break;
            default:
                $timeCondition = ""; // No filter
                break;
        }
    
        // Query per ottenere il totale per utente in base al filtro
        $query = "
            SELECT U.id, U.name, U.surname, SUM(E.amount) as totalAmount
            FROM payments E
            INNER JOIN users U ON E.user_id = U.id
            WHERE E.house_id = ?
            " . ($timeCondition ? "AND $timeCondition" : "") . "
            GROUP BY U.id
        ";
    
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            http_response_code(500); // Return 500 Internal Server Error
            die('Error in query preparation ' . $conn->error);
        }
    
        $stmt->bind_param('i', $house_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    
        return $data; // Restituisci i dati
    }
    

    public function fetchAllWithStatistics($house_id) {
        global $conn;

        $query = "
            SELECT 
                U.id,
                U.name,
                U.surname, 
                COALESCE(A.totalAmount, 0) AS weeklyTotal, 
                COALESCE(B.totalAmount, 0) AS monthlyTotal, 
                COALESCE(C.totalAmount, 0) AS yearlyTotal
            FROM 
                (
                SELECT * FROM users WHERE house_id = ?
                ) as U
            LEFT JOIN
                (
                    SELECT U.id, SUM(E.amount) AS totalAmount
                    FROM payments E
                    INNER JOIN users U ON E.user_id = U.id
                    WHERE E.house_id = ?
                        AND WEEK(E.date) = WEEK(NOW()) 
                        AND YEAR(E.date) = YEAR(NOW())
                    GROUP BY U.id
                ) AS A ON U.id = A.id
            LEFT JOIN
                (
                    SELECT U.id, SUM(E.amount) AS totalAmount
                    FROM payments E
                    INNER JOIN users U ON E.user_id = U.id
                    WHERE E.house_id = ?
                        AND MONTH(E.date) = MONTH(NOW())
                        AND YEAR(E.date) = YEAR(NOW())
                    GROUP BY U.id
                ) AS B ON U.id = B.id
            LEFT JOIN
                (
                    SELECT U.id, SUM(E.amount) AS totalAmount
                    FROM payments E
                    INNER JOIN users U ON E.user_id = U.id
                    WHERE E.house_id = ?
                        AND YEAR(E.date) = YEAR(NOW())
                    GROUP BY U.id
                ) AS C ON U.id = C.id;
        ";
    
        // Prepara la query
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            http_response_code(500); // Return 500 Internal Server Error
            die('Error in query preparation: ' . $conn->error);
        }
    
        // Assicurati di passare solo house_id
        $stmt->bind_param('iiii', $house_id, $house_id, $house_id, $house_id);
        
        // Esegui la query
        if (!$stmt->execute()) {
            http_response_code(500);
            die('Error executing the query: ' . $stmt->error);
        }
    
        $result = $stmt->get_result();
        
        if ($result === false) {
            http_response_code(500);
            die('Error fetching the result: ' . $stmt->error);
        }
    
        $data = $result->fetch_all(MYSQLI_ASSOC);
    
        $stmt->close(); // Chiudi lo statement
        return $data; // Restituisci i dati
    }
    
    // Fetch a single payment by ID
    public function fetchById($id) {
        global $conn;
        $sql = "SELECT * FROM payments WHERE id = ?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            http_response_code(500);
            die('Error in query preparation ' . $conn->error);
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Create a new payment
    public function create($data, $house_id) {
        global $conn;
        $sql = "INSERT INTO payments (house_id, id_user_from, id_user_to, date, amount, payment_method) VALUES (?, ?, ?, ?, ?, ?);";
        
        // Prepare statement
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            http_response_code(500);
            die('Error in query preparation: ' . $conn->error);
        }
    
        // Bind parameters
        $stmt->bind_param('iiisds', $house_id, $data['id_user_from'], $data['id_user_to'], $data['date'], $data['amount'], $data['payment_method']);
    
        // Execute statement and return result
        if ($stmt->execute()) {
            return true; // Successfully inserted
        } else {
            // Log the error
            http_response_code(500);
            die('Error in query execution: ' . $stmt->error);
        }
    }

    // Update an existing payment
    public function update($data) {
        global $conn;
        $sql = "UPDATE payments SET id_user_from = ?, id_user_to = ?, date = ?, amount = ?, payment_method = ? WHERE id = ?";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            http_response_code(500);
            die('Error in query preparation ' . $conn->error);
        }

        //$stmt->bind_param('isssi', $data['user_id'], $data['category'], $data['descr'], $data['date'], $data['id']);
        $stmt->bind_param(
            'iisdsi',                        // Parameter types
            $data['id_user_from'],            // Integer (id_user_from)
            $data['id_user_to'],              // Integer (id_user_to)
            $data['date'],                    // String (date)
            $data['amount'],                  // Double (amount)
            $data['payment_method'],          // String (payment_method)
            $data['id'],                      // Integer (id)
        );

        return $stmt->execute();
    }

    // Delete an expense
    public function delete($id) {
        global $conn;
        $sql = "DELETE FROM payments WHERE id = ?";
        
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            http_response_code(500);
            die('Error in query preparation ' . $conn->error);
        }

        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
?>
