<?php

class CategoryModel {

    public function fetchAll($house_id) {
        global $conn;

        $sql = "SELECT * FROM categories WHERE house_id = ?";
        
        $stmt = $conn->prepare($sql);
        if ($stmt === false) die('Error in query preparation ' . $conn->error);

        $stmt->bind_param('i', $house_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // Create a new houses
    public function create($data, $house_id) {
        global $conn;
        $sql = "INSERT INTO categories (name, house_id) VALUES (?, ?)";
    
        $stmt = $conn->prepare($sql); // Prepare statement 
        if ($stmt === false) die('Error in query preparation ' . $conn->error);
    
        $stmt->bind_param('si', $data['name'], $house_id); // Bind parameters
        if ($stmt->execute()) {
            return $conn->insert_id; // Restituisci l'ID dell'oggetto appena creato
        } else {
            return false; // Restituisci false in caso di errore
        }
    }
    

    // Update an existing category
    // TODO
    public function update($data) {
        global $conn;
        $sql = "UPDATE categories SET name = ? WHERE id = ?";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) die('Error in query preparation ' . $conn->error);

        $stmt->bind_param('si', $data['name'], $data['id'],);
        return $stmt->execute();
    }



    public function delete($id) {
        global $conn;
        $sql = "DELETE FROM categories WHERE id = ?";
        
        $stmt = $conn->prepare($sql);
        if ($stmt === false) die('Error in query preparation ' . $conn->error);

        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
?>
