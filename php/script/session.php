<?php
if (!isset($_SESSION))
  session_start();
$data = [
  'id' => $_SESSION['id'] ?? null,
  'email' => $_SESSION['email'] ?? null,
  'name' => $_SESSION['name'] ?? null,
  'surname' => $_SESSION['surname'] ?? null,
  'house_name' => $_SESSION['house_name'] ?? null,
  'house_id' => $_SESSION['house_id'] ?? null,
];

echo json_encode($data);
?>