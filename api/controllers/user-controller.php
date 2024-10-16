<?php
require_once 'models\user-model.php';

class UserController {
    private $model;

    public function __construct() {
        session_start();
        $this->model = new UserModel(); // Inizializza il modello
    }

    public function handleRequest($method, $request) {
        switch ($method) {
            case 'GET':
                if (isset($request[1])) {
                    $this->getUserById(intval($request[1])); // GET /user/1
                } else {
                    $this->getUser(); // GET /user
                }
                break;

            case 'POST':
                $this->createUser(); // POST /user
                break;

            case 'PUT':
                $this->updateUser(); // PUT /user
                break;

            case 'DELETE':
                if (isset($request[1])) {
                    $this->deleteUser(intval($request[1])); // DELETE /user/1
                }
                break;

            default:
                header("HTTP/1.0 410 Method Not Allowed");
                echo json_encode(['error' => 'Metodo non supportato']);
                break;
        }
    }

    // Funzione per ottenere tutti gli user
    public function getUser() {
        $house_id = $_SESSION['house_id'];

        $data = $this->model->fetchAll($house_id);
        echo json_encode($data);
    }

    public function getUserHouse() {
        $data = $this->model->userHouse();
        echo json_encode($data);
    }

    // Funzione per ottenere un singolo User
    public function getUserById($id) {
        $data = $this->model->fetchById($id);
        if ($data) {
            echo json_encode($data);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['error' => 'User non trovato']);
        }
    }

    // Funzione per creare un nuovo User
    public function createUser() {
        $input = json_decode(file_get_contents("php://input"), true);   // read input from HTTP request
        
        // Decode input from JSON to PHP structure
        if ($this->model->create($input)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Errore durante la creazione']);
        }
    }

    // Funzione per aggiornare un User
     public function updateUser() {
        try {
            // Read input from HTTP request
            $input = json_decode(file_get_contents("php://input"), true);
    
            // Verifica se i dati sono stati decodificati correttamente
            if (json_last_error() !== JSON_ERROR_NONE) {
                header("HTTP/1.0 400 Bad Request");
                echo json_encode(['error' => 'Invalid JSON']);
                return; // Esci dalla funzione
            }
            if (isset($_SESSION['id'])) {
                $user = $this->model->update($input);
                if ($user) {
                    $user = $this->model->fetchById($_SESSION['id']);
                    
                    // Update the session information
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['surname'] = $user['surname'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['house_id'] = $user['house_id'];
                    $_SESSION['house_name'] = $user['house_name'];
                    
                    header("HTTP/1.0 201 Created"); // Usa 201 Created se la risorsa è stata creata con successo
                    echo json_encode($user); // Restituisci i dati dell'User aggiornati
                } else {
                    throw new Exception('User updated, but could not retrieve it.');
                }
            } else {
                throw new Exception('Error while updating user.');
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




    // Funzione per eliminare un User
    public function deleteUser($id) {
        if ($this->model->delete($id)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Errore durante l\'eliminazione']);
        }
    }
}
?>