<?php
$spese = [
    ["utente" => "Alice", "importo" => 100],
    ["utente" => "Bob", "importo" => 80],
    ["utente" => "Charlie", "importo" => 50]
];

$pagamenti = [
    ["pagante" => "Alice", "ricevente" => "Bob", "importo" => 50],
    ["pagante" => "Charlie", "ricevente" => "Alice", "importo" => 25],
    ["pagante" => "Charlie", "ricevente" => "Alice", "importo" => 25],
    ["pagante" => "Bob", "ricevente" => "Alice", "importo" => 25],
    ["pagante" => "Bob", "ricevente" => "Charlie", "importo" => 25]
];

// Calcola la spesa totale e la quota per ciascun utente
$totaleSpese = 0;
foreach ($spese as $spesa) {
    $totaleSpese += $spesa["importo"];
}
$quota = $totaleSpese / count($spese);  // Dividi equamente

$bilanci = [];
// Inizializza i bilanci e sottrai la quota
foreach ($spese as $spesa) {
    $bilanci[$spesa["utente"]] = $spesa["importo"] - $quota;
}

// Applica i pagamenti ai bilanci
foreach ($pagamenti as $pagamento) {
    $bilanci[$pagamento["pagante"]] -= $pagamento["importo"];
    $bilanci[$pagamento["ricevente"]] += $pagamento["importo"];
}

// Separazione dei creditori e dei debitori
$creditori = [];
$debitori = [];
foreach ($bilanci as $utente => $saldo) {
    if ($saldo > 0) {
        $creditori[$utente] = $saldo;
    } elseif ($saldo < 0) {
        $debitori[$utente] = -$saldo;
    }
}

// Stampa i bilanci e le categorie
echo "Bilanci dopo spese e pagamenti:<br>";
foreach ($bilanci as $utente => $saldo) {
    echo "$utente ha un saldo di $saldo<br>";
}

echo "<br>Creditori:<br>";
foreach ($creditori as $utente => $importo) {
    echo "$utente deve ricevere $importo<br>";
}

echo "<br>Debitori:<br>";
foreach ($debitori as $utente => $importo) {
    echo "$utente deve $importo<br>";
}




// Separazione dei creditori e dei debitori
$creditori = [];
$debitori = [];
foreach ($bilanci as $utente => $saldo) {
    if ($saldo > 0) {
        $creditori[$utente] = $saldo;
    } elseif ($saldo < 0) {
        $debitori[$utente] = -$saldo;  // Memorizza il valore assoluto del debito
    }
}


// Processo di minimizzazione delle transazioni
echo "<br>Transazioni necessarie per azzerare i debiti:<br>";
while (!empty($creditori) && !empty($debitori)) {
    $nome_creditore = key($creditori);
    $nome_debitore = key($debitori);
    $importo_creditore = current($creditori);
    $importo_debitore = current($debitori);

    $transazione = min($importo_creditore, $importo_debitore);
    echo "$nome_debitore paga $transazione a $nome_creditore<br>";

    // Aggiorna i bilanci
    if ($importo_creditore > $importo_debitore) {
        $creditori[$nome_creditore] -= $transazione;
        unset($debitori[$nome_debitore]);  // Rimuove il debitore completamente pagato
        reset($debitori);  // Resetta il puntatore dei debitori
    } else {
        $debitori[$nome_debitore] -= $transazione;
        unset($creditori[$nome_creditore]);  // Rimuove il creditore completamente pagato
        reset($creditori);  // Resetta il puntatore dei creditori
    }
}
?>
