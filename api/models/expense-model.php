<?php

class ExpenseModel {

    // Fetch all expenses
    public function fetchAll($house_id, $limit, $offset) {
        global $conn;
    
        // Query per ottenere sia le spese che il numero totale di record
        $query = "
            SELECT SQL_CALC_FOUND_ROWS E.id, E.date, E.user_id, E.category, E.descr, E.amount, E.forusers, U.name, U.surname
            FROM expenses E
            INNER JOIN users U ON  E.user_id = U.id
            WHERE E.house_id = ?
            ORDER BY E.createdAt DESC
            LIMIT ? OFFSET ?
        ";
    
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
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
            'expenses' => $data,
            'total_records' => $totalRecords,
            'current_page' => ($offset / $limit) + 1,
            'total_pages' => $totalPages,
        ];
    }

    public function getAll($house_id) {
        global $conn;
    
        // Query per ottenere sia le spese che il numero totale di record
        $query = "
            SELECT *
            FROM expenses
            WHERE house_id = ?
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
            FROM expenses E
            INNER JOIN users U ON E.user_id = U.id
            WHERE E.house_id = ?
            " . ($timeCondition ? "AND $timeCondition" : "") . "
            GROUP BY U.id
        ";
    
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
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
                    FROM expenses E
                    INNER JOIN users U ON E.user_id = U.id
                    WHERE E.house_id = ?
                        AND WEEK(E.date) = WEEK(NOW()) 
                        AND YEAR(E.date) = YEAR(NOW())
                    GROUP BY U.id
                ) AS A ON U.id = A.id
            LEFT JOIN
                (
                    SELECT U.id, SUM(E.amount) AS totalAmount
                    FROM expenses E
                    INNER JOIN users U ON E.user_id = U.id
                    WHERE E.house_id = ?
                        AND MONTH(E.date) = MONTH(NOW())
                        AND YEAR(E.date) = YEAR(NOW())
                    GROUP BY U.id
                ) AS B ON U.id = B.id
            LEFT JOIN
                (
                    SELECT U.id, SUM(E.amount) AS totalAmount
                    FROM expenses E
                    INNER JOIN users U ON E.user_id = U.id
                    WHERE E.house_id = ?
                        AND YEAR(E.date) = YEAR(NOW())
                    GROUP BY U.id
                ) AS C ON U.id = C.id;
        ";
    
        // Prepara la query
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die('Error in query preparation: ' . $conn->error);
        }
    
        // Assicurati di passare solo house_id
        $stmt->bind_param('iiii', $house_id, $house_id, $house_id, $house_id);
        
        // Esegui la query
        if (!$stmt->execute()) {
            die('Error executing the query: ' . $stmt->error);
        }
    
        $result = $stmt->get_result();
        
        if ($result === false) {
            die('Error fetching the result: ' . $stmt->error);
        }
    
        $data = $result->fetch_all(MYSQLI_ASSOC);
    
        $stmt->close(); // Chiudi lo statement
        return $data; // Restituisci i dati
    }
    

    // Fetch a single expense by ID
    public function fetchById($id) {
        global $conn;
        $sql = "SELECT * FROM expenses WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) die('Error in query preparation ' . $conn->error);

        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Create a new expense
    public function create($data) {
        global $conn;
        $sql = "INSERT INTO expenses (user_id, house_id, amount, category, descr, date, forusers) VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        // Start session only if it's not started
        if (!isset($_SESSION)) session_start();
        $house_id = $_SESSION['house_id'];
    
        // Prepare statement
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Error in query preparation: ' . $conn->error);
        }
    
        // Bind parameters
        $stmt->bind_param('iidssss', $data['user_id'], $house_id, $data['amount'], $data['category'], $data['descr'], $data['date'], $data['forusers']);
    
        // Execute statement and return result
        return $stmt->execute();
    }

    // Update an existing expense
    public function update($data) {
        global $conn;
        $sql = "UPDATE expenses SET user_id = ?, category = ?, descr = ?, date = ?, amount = ?, forusers = ? WHERE id = ?";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) die('Error in query preparation ' . $conn->error);

        $stmt->bind_param('isssssi', $data['user_id'], $data['category'], $data['descr'], $data['date'], $data['amount'], $data['forusers'], $data['id']);
        return $stmt->execute();
    }

    // Delete an expense
    public function delete($id) {
        global $conn;
        $sql = "DELETE FROM expenses WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) die('Error in query preparation ' . $conn->error);

        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
?>
