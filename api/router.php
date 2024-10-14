<?php
// API RESTful approach
/*
    
    In questo file, gestiamo tutte le richieste verso la tua API, instradandole al controller 
    corappropriato in base all'endpoint e al metodo HTTP. Questo ti permette di avere un solo 
    punto di ingresso per tutte le operazioni.

*/

require_once 'controllers\user-controller.php';
require_once 'controllers\auth-controller.php'; // Includi il nuovo controller per l'autenticazione

// Ottieni il metodo HTTP e l'endpoint richiesto
$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'], '/')); // Prende l'endpoint dall'URL

// Verifica l'endpoint e instrada la richiesta al controller corretto
switch ($request[0]) {
    case 'user':
        $controller = new UtentiController();
        $controller->handleRequest($method, $request);
        break;

    case 'register':
        if ($method === 'POST') {
            $authController = new AuthController();
            $authController->register(); // Chiama il metodo di registrazione
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            echo json_encode(['error' => 'Method not allowed']);
        }
        break;

    // Altri endpoint possono essere aggiunti qui, es. prodotti, ordini, ecc.

    default:
        header("HTTP/1.0 404 Not Found");
        echo json_encode(['error' => 'Endpoint not found']);
        break;
}
?>
