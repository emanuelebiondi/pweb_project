<?php
// API RESTful approach
/*
    
    In questo file, gestiamo tutte le richieste verso la tua API, instradandole al controller 
    corappropriato in base all'endpoint e al metodo HTTP. Questo ti permette di avere un solo 
    punto di ingresso per tutte le operazioni.

*/

require_once 'controllers/user-controller.php';
require_once 'controllers/auth-controller.php';
require_once 'controllers/expance-controller.php';
require_once 'controllers/house-controller.php';

require_once '../config/database.php'; // Include la connessione al database

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

    case 'user':
        $controller = new UserController();
        $controller->handleRequest($method, $request);
        break;

    case 'expance':
        $controller = new ExpanceController();
        $controller->handleRequest($method, $request);
        break;

    case 'house':
        $controller = new HouseController();
        $controller->handleRequest($method, $request);
        break;

    // Altri endpoint possono essere aggiunti qui, es. prodotti, ordini, ecc.

    default:
        header("HTTP/1.0 404 Not Found");
        echo json_encode(['error' => 'Endpoint not found']);
        break;
}
?>
