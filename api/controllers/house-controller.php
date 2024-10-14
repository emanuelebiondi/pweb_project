<?php
require_once 'models/house-model.php';

class HouseController {
    private $model;

    public function __construct() {
        $this->model = new HouseModel(); // Initialize the model
    }

    public function handleRequest($method, $request) {
        switch ($method) {
            case 'GET':
                if (isset($request[1])) {
                    $this->getHouseById(intval($request[1])); // GET /house/1
                } 
                break;

            case 'POST':
                $this->createHouse(); // POST /house
                break;

            case 'PUT':
                $this->updateHouse(); // PUT /house
                break;

            default:
                header("HTTP/1.0 405 Method Not Allowed");
                echo json_encode(['error' => 'Method not supported']);
                break;
        }
    }

    // Function to fetch a single house by ID
    public function getHouseById($id) {

        $data = $this->model->fetchById($id);
        if ($data) {
            echo json_encode($data);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['error' => 'House not found']);
        }
    }

    // Function to create a new house
    public function createHouse() {
        try {
            // Read input from HTTP request
            $input = json_decode(file_get_contents("php://input"), true);
    
            // Verifica se i dati sono stati decodificati correttamente
            if (json_last_error() !== JSON_ERROR_NONE) {
                header("HTTP/1.0 400 Bad Request");
                echo json_encode(['error' => 'Invalid JSON']);
                return; // Esci dalla funzione
            }
    
            // Chiamata al modello per creare la casa e recuperare l'ID
            $houseId = $this->model->create($input);
    
            if ($houseId) {
                // Recupera il record completo della casa appena creata
                $newHouse = $this->model->fetchById($houseId);
                if ($newHouse) {
                    header("HTTP/1.0 201 Created"); // Usa 201 Created se la risorsa è stata creata con successo
                    echo json_encode($newHouse); // Restituisci i dati della casa appena creata
                } else {
                    throw new Exception('House created, but could not retrieve it.');
                }
            } else {
                throw new Exception('Error while creating house.');
            }
        } catch (Exception $e) {
            // Gestione delle eccezioni
            header("HTTP/1.0 500 Internal Server Error"); // Codice 500 per errori sul server
            echo json_encode(['error' => $e->getMessage()]); // Restituisci il messaggio dell'eccezione
        } catch (Throwable $t) {
            // Gestione di eventuali errori non catturati
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode(['error' => 'An unexpected error occurred: ' . $t->getMessage()]);
        }
    }
    

    // Function to update a house
    public function updateHouse() {
        $input = json_decode(file_get_contents("php://input"), true);
        if ($this->model->update($input)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Error while updating']);
        }
    }


}
?>
