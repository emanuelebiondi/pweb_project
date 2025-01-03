<?php
require_once 'models/expense-model.php';

class expenseController
{
  private $model;

  public function __construct()
  {
    if (!isset($_SESSION))
      session_start();
    $this->model = new expenseModel(); // Initialize the model
  }

  public function handleRequest($method, $request)
  {
    switch ($method) {
      case 'GET':
        if (isset($request[1]) && $request[1] === 'all') {
          $this->getExpensesWithPagination(); // GET /expense/pagination?page={page}
        } else if (isset($request[1]) && $request[1] === 'statistics') {
          $this->getExpensesStatistics(); // GET /expense/statistics
        } else {
          $this->getexpenseById(intval($request[1])); // GET /expense/1
        }
        break;

      case 'POST':
        $this->createExpense(); // POST /expense
        break;

      case 'PUT':
        $this->updateExpense(); // PUT /expense
        break;

      case 'DELETE':
        if (isset($request[1])) {
          $this->deleteexpense(intval($request[1])); // DELETE /expense/1
        }
        break;

      default:
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode(['error' => 'Method not supported']);
        break;
    }
  }

  // Function to fetch all expenses
  public function getExpensesWithPagination()
  {
    $house_id = $_SESSION['house_id'];
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Ottieni la pagina
    $limit = 9; // Numero di risultati per pagina
    $offset = ($page - 1) * $limit; // Calcola l'offset

    $data = $this->model->fetchAll($house_id, $limit, $offset);
    echo json_encode($data);
  }

  public function getExpensesStatistics()
  {
    $house_id = $_SESSION['house_id'];
    $data = $this->model->fetchAllWithStatistics($house_id);
    echo json_encode($data);
  }


  // Function to fetch a single expense by ID
  public function getexpenseById($id)
  {
    $data = $this->model->fetchById($id);
    if ($data) {
      echo json_encode($data);
    } else {
      header("HTTP/1.0 404 Not Found");
      echo json_encode(['success' => false, 'error' => 'Expense not found']);
    }
  }

  // Function to create a new expense
  public function createExpense()
  {
    $input = json_decode(file_get_contents("php://input"), true);   // Read input from HTTP request


    // Decode input from JSON to PHP structure
    $data = $this->model->create($input);
    if ($data) {
      echo json_encode($data);
    } else {
      header("HTTP/1.0 500 Internal Server Error");
      echo json_encode(['success' => false, 'error' => 'Error while creating']);
    }
  }

  // Function to update an expense
  public function updateExpense()
  {
    $input = json_decode(file_get_contents("php://input"), true);
    if ($this->model->update($input)) {
      echo json_encode(['success' => true]);
    } else {
      header("HTTP/1.0 500 Internal Server Error");
      echo json_encode(['success' => false, 'error' => 'Error while updating']);
    }
  }

  // Function to delete an expense
  public function deleteexpense($id)
  {
    if ($this->model->delete($id)) {
      echo json_encode(['success' => true]);
    } else {
      header("HTTP/1.0 500 Internal Server Error");
      echo json_encode(['success' => false, 'error' => 'Error while deleting']);
    }
  }
}

?>