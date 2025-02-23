<?php

class HouseModel
{

  // Fetch a single house by ID
  public function fetchById($id)
  {
    global $conn;
    $sql = "SELECT * FROM houses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false)
      die('Error in query preparation ' . $conn->error);

    $stmt->bind_param('i', $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  // Fetch a single house by join code
  public function fetchByJoinCode($join_code)
  {
    global $conn;
    $sql = "SELECT * FROM houses WHERE join_code = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false)
      die('Error in query preparation ' . $conn->error);

    $stmt->bind_param('s', $join_code);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  // Fetch a single house by house id, return only the join code
  public function findJoinCode($house_id)
  {
    global $conn;
    $sql = "SELECT join_code FROM houses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false)
      die('Error in query preparation ' . $conn->error);

    $stmt->bind_param('i', $house_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
  }

  // Create a new houses
  public function create($data)
  {
    global $conn;
    $sql = "INSERT INTO houses (name, join_code) VALUES (?, ?)";

    $stmt = $conn->prepare($sql); // Prepare statement 
    if ($stmt === false)
      die('Error in query preparation ' . $conn->error);

    // Generate the join code
    $join_code = substr(md5(time()), 0, 6); // Generate a 6 caracter long join code

    $stmt->bind_param('ss', $data['house_name'], $join_code); // Bind parameters
    if ($stmt->execute()) {
      return $conn->insert_id; // Restituisci l'ID dell'oggetto appena creato
    } else {
      return false; // Restituisci false in caso di errore
    }
  }


  // Update an existing house
  /* NOTE: non in uso al momento
  public function update($data) {
      global $conn;
      $sql = "UPDATE houses SET name = ? WHERE id = ?";

      $stmt = $conn->prepare($sql);
      if ($stmt === false) die('Error in query preparation ' . $conn->error);

      $stmt->bind_param('si', $data['name'], $data['id'],);
      return $stmt->execute();
  }
  */
}
?>