<?php

// Dati degli utenti
$utenti = [
    ["utente" => "Alice", "data" => 0],
    ["utente" => "Bob", "data" => 1],
    ["utente" => "Charlie", "data" => 1],
    ["utente" => "Antonio", "data" => 10]
];

// Dati delle spese
$spese = [
    ["utente" => "Alice", "importo" => 100, "data" => 4, "for" => ["Alice", "Charlie", "Antonio"]],
    ["utente" => "Bob", "importo" => 80, "data" => 1, "for" => ["Alice", "Bob", "Charlie", "Antonio"]],
    ["utente" => "Charlie", "importo" => 50, "data" => 1, "for" => ["Alice", "Bob", "Charlie"]],
    ["utente" => "Antonio", "importo" => 50, "data" => 1, "for" => ["Alice", "Bob", "Charlie"]]
];

// Dati dei pagamenti
$pagamenti = [
    ["pagante" => "Alice", "ricevente" => "Bob", "importo" => 10],
    ["pagante" => "Charlie", "ricevente" => "Alice", "importo" => 15],
    ["pagante" => "Charlie", "ricevente" => "Alice", "importo" => 100],
    ["pagante" => "Bob", "ricevente" => "Alice", "importo" => 200],
    ["pagante" => "Bob", "ricevente" => "Charlie", "importo" => 3]
];
// Calcola la spesa totale e la quota
$totaleSpese = array_reduce($spese, function ($totale, $spesa) {
    return $totale + $spesa["importo"];
}, 0);

$quota = $totaleSpese / count($utenti); // Dividi equamente

// Inizializza i bilanci e sottrai la quota
$bilanci = [];
foreach ($spese as $spesa) {
    $quotaPerUtente = $spesa["importo"] / count($spesa["for"]);
    $bilanci[$spesa["utente"]] = ($bilanci[$spesa["utente"]] ?? 0) + $spesa["importo"];

    foreach ($spesa["for"] as $utente) {
        $bilanci[$utente] = ($bilanci[$utente] ?? 0) - $quotaPerUtente;
    }
}

// Stampa i bilanci
echo "Bilanci dopo spese e pagamenti:<br>";
foreach ($bilanci as $utente => $saldo) {
    echo "$utente ha un saldo di $saldo<br>";
}

// Applica i pagamenti ai bilanci
foreach ($pagamenti as $pagamento) {
    $bilanci[$pagamento["pagante"]] -= $pagamento["importo"];
    $bilanci[$pagamento["ricevente"]] += $pagamento["importo"];
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
echo "\nCreditori:<br>";
foreach ($creditori as $utente => $importo) {
    echo "$utente deve ricevere $importo<br>";
}

// Stampa i debitori
echo "\nDebitori:<br>";
foreach ($debbitori as $utente => $importo) {
    echo "$utente deve $importo<br>";
}

// Minimizzazione delle transazioni
echo "\nTransazioni necessarie per azzerare i debiti:<br>";
while (count($creditori) > 0 && count($debbitori) > 0) {
    $nome_creditore = key($creditori);
    $nome_debitore = key($debbitori);
    $importo_creditore = $creditori[$nome_creditore];
    $importo_debitore = $debbitori[$nome_debitore];

    $transazione = min($importo_creditore, $importo_debitore);
    echo "$nome_debitore paga $transazione a $nome_creditore<br>";

    // Aggiorna i bilanci
    if ($importo_creditore > $importo_debitore) {
        $creditori[$nome_creditore] -= $transazione;
        unset($debbitori[$nome_debitore]);
    } else {
        $debbitori[$nome_debitore] -= $transazione;
        unset($creditori[$nome_creditore]);
    }
}
?>
