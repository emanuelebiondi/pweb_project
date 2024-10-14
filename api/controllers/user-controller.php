<?php
require_once 'models\user-model.php';

class UserController {
    private $model;

    public function __construct() {
        $this->model = new UserModel(); // Inizializza il modello
    }

    public function handleRequest($method, $request) {
        switch ($method) {
            case 'GET':
                if (isset($request[1])) {
                    $this->getUtente(intval($request[1])); // GET /user/1
                } else {
                    $this->getuser(); // GET /user
                }
                break;

            case 'POST':
                $this->createUtente(); // POST /user
                break;

            case 'PUT':
                $this->updateUtente(); // PUT /user
                break;

            case 'DELETE':
                if (isset($request[1])) {
                    $this->deleteUtente(intval($request[1])); // DELETE /user/1
                }
                break;

            default:
                header("HTTP/1.0 405 Method Not Allowed");
                echo json_encode(['error' => 'Metodo non supportato']);
                break;
        }
    }

    // Funzione per ottenere tutti gli user
    public function getuser() {
        $data = $this->model->fetchAll();
        echo json_encode($data);
    }

    // Funzione per ottenere un singolo utente
    public function getUtente($id) {
        $data = $this->model->fetchById($id);
        if ($data) {
            echo json_encode($data);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['error' => 'Utente non trovato']);
        }
    }

    // Funzione per creare un nuovo utente
    public function createUtente() {
        $input = json_decode(file_get_contents("php://input"), true);   // read input from HTTP request
        
        // Decode input from JSON to PHP structure
        if ($this->model->create($input)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Errore durante la creazione']);
        }
    }

    // Funzione per aggiornare un utente
    public function updateUtente() {
        $input = json_decode(file_get_contents("php://input"), true);
        if ($this->model->update($input)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Errore durante l\'aggiornamento']);
        }
    }

    // Funzione per eliminare un utente
    public function deleteUtente($id) {
        if ($this->model->delete($id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Errore durante l\'eliminazione']);
        }
    }
}
?>