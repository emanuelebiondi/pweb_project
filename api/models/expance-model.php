<?php
//require_once '..\config\database.php'; // Include the database connection

class ExpanceModel {

    // Fetch all expenses
    public function fetchAll() {
        global $conn;
        $sql = "SELECT * FROM expance";
        $result = $conn->query($sql);

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Fetch a single expense by ID
    public function fetchById($id) {
        global $conn;
        $sql = "SELECT * FROM expance WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) die('Error in query preparation ' . $conn->error);

        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Create a new expense
    public function create($data) {
        global $conn;
        $sql = "INSERT INTO expance (user_id, category, descr, date) VALUES (?, ?, ?, ?)";

        $stmt = $conn->prepare($sql); // Prepare statement 
        if ($stmt === false) die('Error in query preparation ' . $conn->error);

        $stmt->bind_param('isss', $data['user_id'], $data['category'], $data['descr'], $data['date']); // Bind parameters
        return $stmt->execute();
    }

    // Update an existing expense
    public function update($data) {
        global $conn;
        $sql = "UPDATE expance SET user_id = ?, category = ?, descr = ?, date = ? WHERE id = ?";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) die('Error in query preparation ' . $conn->error);

        $stmt->bind_param('isssi', $data['user_id'], $data['category'], $data['descr'], $data['date'], $data['id']);
        return $stmt->execute();
    }

    // Delete an expense
    public function delete($id) {
        global $conn;
        $sql = "DELETE FROM expance WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) die('Error in query preparation ' . $conn->error);

        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
?>
