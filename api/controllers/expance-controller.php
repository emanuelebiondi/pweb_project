<?php
require_once 'models\expance-model.php';

class ExpanceController {
    private $model;

    public function __construct() {
        $this->model = new ExpanceModel(); // Initialize the model
    }

    public function handleRequest($method, $request) {
        switch ($method) {
            case 'GET':
                if (isset($request[1])) {
                    $this->getExpanceById(intval($request[1])); // GET /expance/1
                } else {
                    $this->getExpance(); // GET /expance
                }
                break;

            case 'POST':
                $this->createExpance(); // POST /expance
                break;

            case 'PUT':
                $this->updateExpance(); // PUT /expance
                break;

            case 'DELETE':
                if (isset($request[1])) {
                    $this->deleteExpance(intval($request[1])); // DELETE /expance/1
                }
                break;

            default:
                header("HTTP/1.0 405 Method Not Allowed");
                echo json_encode(['error' => 'Method not supported']);
                break;
        }
    }

    // Function to fetch all expenses
    public function getExpance() {
        $data = $this->model->fetchAll();
        echo json_encode($data);
    }

    // Function to fetch a single expense by ID
    public function getExpanceById($id) {
        $data = $this->model->fetchById($id);
        if ($data) {
            echo json_encode($data);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['error' => 'Expense not found']);
        }
    }

    // Function to create a new expense
    public function createExpance() {
        $input = json_decode(file_get_contents("php://input"), true);   // Read input from HTTP request
        
        // Decode input from JSON to PHP structure
        if ($this->model->create($input)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error while creating']);
        }
    }

    // Function to update an expense
    public function updateExpance() {
        $input = json_decode(file_get_contents("php://input"), true);
        if ($this->model->update($input)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error while updating']);
        }
    }

    // Function to delete an expense
    public function deleteExpance($id) {
        if ($this->model->delete($id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error while deleting']);
        }
    }
}
?>
