<?php
// RESTful API approach
/*
    In questo file, gestiamo tutte le richieste verso la tua API, instradandole al controller 
    corappropriato in base all'endpoint e al metodo HTTP. Questo permette di avere un solo 
    punto di ingresso per tutte le operazioni.

*/
require_once '../config/database.php'; // Include la connessione al database

require_once 'middlewares/auth-middleware.php'; // Includi il middleware

require_once 'controllers/user-controller.php';
require_once 'controllers/auth-controller.php';
require_once 'controllers/expense-controller.php';
require_once 'controllers/payment-controller.php';
require_once 'controllers/house-controller.php';
require_once 'controllers/category-controller.php';
require_once 'controllers/reminder-controller.php';



// Array di endpoint pubblici
$publicEndpoints = ['register', 'login'];


// Middleware per autenticazione
checkAuthentication($publicEndpoints);


// Ottieni il metodo HTTP e l'endpoint richiesto
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/')); // Prende l'endpoint dall'URL


// Verifica l'endpoint e instrada la richiesta al controller corretto
switch ($request[0]) {
  case 'register':
    if ($method === 'POST') {
      $authController = new AuthController();
      $authController->register(); // Chiama il metodo di registrazione
    }
    break;

  case 'login':
    if ($method === 'POST') {
      $authController = new AuthController();
      $authController->login(); // Chiama il metodo di registrazione
    }
    break;

  case 'passwordChange':
    if ($method === 'POST') {
      $authController = new AuthController();
      $authController->passwordChange(); // Chiama il metodo di registrazione
    }
    break;


  case 'user':
    $controller = new UserController();
    $controller->handleRequest($method, $request);
    break;

  case 'expense':
    $controller = new expenseController();
    $controller->handleRequest($method, $request);
    break;

  case 'payment':
    $controller = new PaymentController();
    $controller->handleRequest($method, $request);
    break;

  case 'house':
    $controller = new HouseController();
    $controller->handleRequest($method, $request);
    break;

  case 'category':
    $controller = new CategoryController();
    $controller->handleRequest($method, $request);
    break;

  case 'reminder':
    $controller = new ReminderController();
    $controller->handleRequest($method, $request);
    break;


  default:
    header("HTTP/1.0 404 Not Found");
    echo json_encode(['error' => 'Endpoint not found']);
    //echo error_log("Received request: Method = $method, Request = " . json_encode($request));
    break;
}
?>