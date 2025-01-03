<?php


function checkAuthentication($excludedEndpoints)
{
  if (!isset($_SESSION))
    session_start();

  // Ottieni l'endpoint corrente (escludendo il nome del file se presente)
  $requestUri = $_SERVER['REQUEST_URI'];
  $scriptName = $_SERVER['SCRIPT_NAME']; // Nome del file (es. /api/router.php)

  // Rimuovi il nome del file dal percorso
  $path = str_replace(dirname($scriptName), '', $requestUri);
  $currentEndpoint = explode('/', trim(parse_url($path, PHP_URL_PATH), '/'))[1];
  // Nota: parse_url restituisce il percorso senza query string
  //       trim() rimuove gli slash iniziali e finali,
  //       explode() divide il percorso in un array di stringhe quindi [ 'router.php', 'endpoint' ]

  //echo $currentEndpoint;
  //var_dump( explode('/', trim(parse_url($path, PHP_URL_PATH), '/')));

  // Escludi endpoint pubblici (login, register)
  if (in_array($currentEndpoint, $excludedEndpoints)) {
    return true;
  }

  // Controlla se l'utente è loggato
  if (!isset($_SESSION['id'])) {
    header("HTTP/1.0 401 Unauthorized");
    echo json_encode(['error' => 'User not authenticated']);
    exit;
  }
}



?>