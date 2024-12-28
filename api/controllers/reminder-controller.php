<?php
require_once 'models/reminder-model.php';

class ReminderController {
    private $model;

    public function __construct() {
        session_start();
        $this->model = new ReminderModel(); // Initialize the model
    }

    public function handleRequest($method, $request) {
        switch ($method) {
            case 'GET':
                $this->getReminders(); // GET /Reminder
                break;

            case 'POST':
                $this->createReminder(); // POST /Reminder
                break;

            case 'PUT':
                $this->updateReminder(); // PUT /house
                break;
            
            case 'DELETE':
                if (isset($request[1])) {
                    $id = $request[1]; // Supponendo che l'ID venga passato come parte della URL
                    $this->deleteReminder($id); // DELETE /Reminder/{id}
                }
                break;

            default:
                header("HTTP/1.0 405 Method Not Allowed");
                echo json_encode(['error' => 'Method not supported']);
                break;
        }
    }

    public function getReminders() {
        $house_id = $_SESSION['house_id'];
        $data = $this->model->fetchAll($house_id);
        //var_dump($data);
        if (!empty($data)) {
            echo json_encode($data);
        } else {
            
            echo json_encode([]);  // Restituisce un array vuoto invece del messaggio di errore
        }
    }

    // Function to create a new reminder
    public function createReminder() {
        try {
            // Read input from HTTP request
            $input = json_decode(file_get_contents("php://input"), true);
            $houseId = $_SESSION['house_id'];
            
            $data = $this->model->create($input, $houseId);
            if($data)
                echo json_encode($data);
            else 
                echo json_encode(['success' => false, 'error' => 'Error while creating new reminder']);
        } catch (Exception $e) {
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    

    // Function to update a house
    public function updateReminder() {
        $input = json_decode(file_get_contents("php://input"), true);
        if ($this->model->update($input))
            echo json_encode(['success' => true]);
        else{
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode(['success' => false, 'error' => 'Error while updating reminder']);
            }
        }


    public function deleteReminder($id) {
        if ($this->model->delete($id))
            echo json_encode(['success' => true]);
        else{
                header("HTTP/1.0 500 Internal Server Error");
                echo json_encode(['success' => false, 'error' => 'Error while deleting reminder']);
            }
    }

}

?>
