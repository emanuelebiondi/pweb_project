<?php
require_once 'models/payment-model.php';
require_once 'models/expense-model.php';    // Needed for settleUp
require_once 'models/user-model.php';       // Needed for settleUp

class PaymentController
{
  private $model;

  public function __construct()
  {
    if (!isset($_SESSION))
      session_start();
    $this->model = new PaymentModel(); // Initialize the model
  }

  public function handleRequest($method, $request)
  {
    switch ($method) {
      case 'GET':
        if (isset($request[1]) && $request[1] === 'all') {
          $this->getPaymentWithPagination(); // GET /payment/pagination?page={page}
        } else if (isset($request[1]) && $request[1] === 'settleup') {
          $this->getSettleUp(); // GET /payment/settleup
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
  public function getPaymentWithPagination()
  {
    $house_id = $_SESSION['house_id'];
    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1; // Ottieni la pagina
    $limit = 9; // Numero di risultati per pagina
    $offset = ($page - 1) * $limit; // Calcola l'offset

    $data = $this->model->fetchAll($house_id, $limit, $offset);
    echo json_encode($data);
  }

  // Function to fetch a single payment by ID
  public function getpaymentById($id)
  {
    $data = $this->model->fetchById($id);
    if ($data) {
      echo json_encode($data);
    } else {
      header("HTTP/1.0 404 Not Found");
      echo json_encode(['error' => 'Expense not found']);
    }
  }

  // Function to create a new payment
  public function createPayment()
  {
    $input = json_decode(file_get_contents("php://input"), true);   // Read input from HTTP request
    // Start session only if it's not started
    if (!isset($_SESSION))
      session_start();
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
  public function updatePayment()
  {
    $input = json_decode(file_get_contents("php://input"), true);
    $data = $this->model->update($input);
    if ($data) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['error' => 'Error while updating']);
    }
  }

  // Function to delete an payment
  public function deletePayment($id)
  {
    if ($this->model->delete($id)) {
      echo json_encode(['success' => true]);
    } else {
      echo json_encode(['success' => false, 'error' => 'Error while deleting']);
    }
  }


  public function getSettleUp()
  {
    $house_id = $_SESSION['house_id'];

    $utenti = new UserModel();
    $utenti = $utenti->fetchAll($house_id);  // Get all users

    $spese = new ExpenseModel();
    $spese = $spese->getAll($house_id);  // Get all expenses

    $pagamenti = new PaymentModel();
    $pagamenti = $pagamenti->getAll($house_id);  // Get all payments

    // Modificare l'array per cambiare il campo 'forusers' in un array PHP
    foreach ($spese as $key => $item) {
      if (isset($item['forusers']) && $item['forusers'] !== null) {
        // Decodifica la stringa JSON di 'forusers' in un array associativo
        $forusers = json_decode($item['forusers'], true);

        // Se la decodifica è riuscita, estrai l'array degli utenti
        if (isset($forusers['users']) && is_array($forusers['users'])) {
          // Riassegna il campo 'forusers' come array di ID utenti direttamente nell'array $spese
          $spese[$key]['forusers'] = $forusers['users'];
        }
      }
    }

    //var_dump($spese);
    //var_dump($utenti);
    //var_dump($pagamenti);


    // Calcola la spesa totale e la quota
    $totaleSpese = array_reduce($spese, function ($totale, $spesa) {
      return $totale + $spesa["amount"];
    }, 0);

    $quota = $totaleSpese / count($utenti); // Dividi equamente

    // Inizializza i bilanci e sottrai la quota
    $bilanci = [];
    foreach ($spese as $spesa) {

      if (!isset($spesa["forusers"]) || !is_array($spesa["forusers"]) || count($spesa["forusers"]) === 0) {
        $quotaPerUtente = 0;
      } else {
        $quotaPerUtente = $spesa["amount"] / count($spesa["forusers"]);
      }


      $bilanci[$spesa["user_id"]] = ($bilanci[$spesa["user_id"]] ?? 0) + $spesa["amount"];

      foreach ($spesa["forusers"] as $utente) {
        $bilanci[$utente] = ($bilanci[$utente] ?? 0) - $quotaPerUtente;
      }
    }

    // Stampa i bilanci
    //echo "Bilanci dopo spese e pagamenti:\n";
    foreach ($bilanci as $utente => $saldo) {
      //echo "$utente ha un saldo di $saldo\n";
    }

    // Applica i pagamenti ai bilanci
    foreach ($pagamenti as $pagamento) {
      $bilanci[$pagamento["id_user_from"]] += $pagamento["amount"];
      $bilanci[$pagamento["id_user_to"]] -= $pagamento["amount"];
    }

    // Separazione dei creditori e dei debitori
    $creditori = [];
    $debbitori = [];
    foreach ($bilanci as $utente => $saldo) {
      if ($saldo > 0) {
        $creditori[$utente] = $saldo;
      } elseif ($saldo < 0) {
        $debbitori[$utente] = -$saldo; // Memorizza il valore assoluto del debito
      }
    }

    // Stampa i creditori
    //echo "\nCreditori:\n";
    foreach ($creditori as $utente => $importo) {
      //echo "$utente deve ricevere $importo\n";
    }

    // Stampa i debitori
    //echo "\nDebitori:\n";
    foreach ($debbitori as $utente => $importo) {
      //echo "$utente deve $importo\n";
    }

    // Crea una mappa per una facile associazione degli ID
    $mappa_utenti = [];
    foreach ($utenti as $utente) {
      $mappa_utenti[$utente["id"]] = $utente;
    }

    $transazioni = [];
    //echo "\nTransazioni necessarie per azzerare i debiti:\n";
    while (count($creditori) > 0 && count($debbitori) > 0) {
      $nome_creditore = key($creditori);
      $nome_debitore = key($debbitori);
      $importo_creditore = $creditori[$nome_creditore];
      $importo_debitore = $debbitori[$nome_debitore];

      $transazione = min($importo_creditore, $importo_debitore);
      //echo "$nome_debitore paga $transazione a $nome_creditore\n";

      // Aggiunge la transazione al JSON
      $transazioni[] = [
        "id_user_from" => $nome_debitore,
        "name_user_from" => $mappa_utenti[$nome_debitore]["name"],
        "surname_user_from" => $mappa_utenti[$nome_debitore]["surname"],
        "id_user_to" => $nome_creditore,
        "name_user_to" => $mappa_utenti[$nome_creditore]["name"],
        "surname_user_to" => $mappa_utenti[$nome_creditore]["surname"],
        "amount" => $transazione
      ];

      // Aggiorna i bilanci
      if ($importo_creditore > $importo_debitore) {
        $creditori[$nome_creditore] -= $transazione;
        unset($debbitori[$nome_debitore]);
      } else {
        $debbitori[$nome_debitore] -= $transazione;
        unset($creditori[$nome_creditore]);
      }
    }

    // Stampa il JSON risultante
    echo json_encode($transazioni, JSON_PRETTY_PRINT);
  }

}

?>