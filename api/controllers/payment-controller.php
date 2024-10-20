<?php
require_once 'models/payment-model.php';

class PaymentController {
    private $model;

    public function __construct() {
        if (!isset($_SESSION)) session_start();
        $this->model = new PaymentModel(); // Initialize the model
    }

    public function handleRequest($method, $request) {
        switch ($method) {
            case 'GET':
                if (isset($request[1]) && $request[1] === 'all') {
                    $this->getPaymentWithPagination(); // GET /payment/pagination?page={page}
                } else if (isset($request[1]) && $request[1] === 'statistics') {
                    $this->getPaymentStatistics(); // GET /payment/statistics
                }
                break;

            case 'POST':
                $this->createPayment(); // POST /payment
                break;

            case 'PUT':
                $this->updatePayment(); // PUT /payment
                break;

            case 'DELETE':
                if (isset($request[1])) {
                    $this->deletePayment(intval($request[1])); // DELETE /payment/1
                }
                break;

            default:
                header("HTTP/1.0 405 Method Not Allowed");
                echo json_encode(['error' => 'Method not supported']);
                break;
        }
    }

    // Function to fetch all Payment
    public function getPaymentWithPagination() {
        $house_id = $_SESSION['house_id'];
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Ottieni la pagina
        $limit = 9; // Numero di risultati per pagina
        $offset = ($page - 1) * $limit; // Calcola l'offset
    
        $data = $this->model->fetchAll($house_id, $limit, $offset);
        echo json_encode($data);
    }

    public function getPaymentStatistics() {
        $house_id = $_SESSION['house_id'];
        $data = $this->model->fetchAllWithStatistics($house_id);
        echo json_encode($data);
    }


    // Function to fetch a single payment by ID
    public function getpaymentById($id) {
        $data = $this->model->fetchById($id);
        if ($data) {
            echo json_encode($data);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['error' => 'Expense not found']);
        }
    }

    // Function to create a new payment
    public function createPayment() {
        $input = json_decode(file_get_contents("php://input"), true);   // Read input from HTTP request
        // Start session only if it's not started
        if (!isset($_SESSION)) session_start();
        $house_id = $_SESSION['house_id'];
    
        
        // Decode input from JSON to PHP structure
        $data = $this->model->create($input, $house_id);
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'Error while creating']);
        }
    }

    // Function to update an payment
    public function updatePayment() {
        $input = json_decode(file_get_contents("php://input"), true);
        $data = $this->model->update($input);
        if ($data) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Error while updating']);
        }
    }

    // Function to delete an payment
    public function deletepayment($id) {
        if ($this->model->delete($id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error while deleting']);
        }
    }
}

?>
