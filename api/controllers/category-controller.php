<?php
require_once 'models/category-model.php';

class CategoryController {
    private $model;

    public function __construct() {
        if (!isset($_SESSION)) session_start();
        $this->model = new CategoryModel(); // Initialize the model
    }

    public function handleRequest($method, $request) {
        switch ($method) {
            case 'GET':
                $this->getCategories(); // GET /Category
                break;

            case 'POST':
                $this->createCategory(); // POST /Category
                break;

            case 'PUT':
                $this->updateCategory(); // PUT /category
                break;

            case 'DELETE':
                if (isset($request[1])) {
                    $id = $request[1]; // Supponendo che l'ID venga passato come parte della URL
                    $this->deleteCategory($id); // DELETE /category/{id}
                }
                break;

            default:
                header("HTTP/1.0 405 Method Not Allowed");
                echo json_encode(['error' => 'Method not supported']);
                break;
        }
    }

    public function getCategories() {
        $house_id = $_SESSION['house_id'];
        $data = $this->model->fetchAll($house_id);
        //var_dump($data);
        if ($data) {
            echo json_encode($data);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['error' => 'Categories not found']);
        }
    }

    // Function to create a new category
    public function createCategory() {

        // Read input from HTTP request
        $input = json_decode(file_get_contents("php://input"), true);
        
        $houseId = $_SESSION['house_id'];
        $data = $this->model->create($input, $houseId);
        
        if($data)
            echo json_encode($data);
        else 
            echo json_encode(['success' => false, 'error' => 'Error while creating new category']);
    }
    
    public function updateCategory() {
        $input = json_decode(file_get_contents("php://input"), true);
        if ($this->model->update($input))
            echo json_encode(['success' => true]);
        else
            echo json_encode(['success' => false, 'error' => 'Error while updating category']);
    }


    public function deleteCategory($id) {
        if ($this->model->delete($id))
            echo json_encode(['success' => true]);
        else{
                header("HTTP/1.0 500 Internal Server Error");
                echo json_encode(['success' => false, 'error' => 'Error while deleting category']);
            }
    }
}

?>
