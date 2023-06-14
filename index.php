<?php
include('navigation.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client = $_POST["client"];
    $destination = $_POST["destination"];
    $packages = $_POST["packages"];
    $weight = $_POST["weight"];
    $payer = $_POST["payer"];

    // Charger les fichiers XML
    $tariffs = simplexml_load_file('tarif.xml');
    $conditions = simplexml_load_file('/dossier XML/conditiontaxation.xml');
    $clients = simplexml_load_file('/dossier XML/client.xml'); 
    $localisations = simplexml_load_file('/dossier XML/localite.xml');

    // Utiliser les fichiers XML pour effectuer les calculs nécessaires
    $zone = getZone($destination, $localisations);
    $tariff = getTariff($client, $zone, $tariffs);
    $tax = getTax($client, $payer, $conditions);
    $total = calculateHT($packages, $weight, $tariff, $tax);

    echo "Le montant HT est: " . $total;
}

function getZone($destination, $localisations) {
    $zone = null;
    foreach ($localisations->Zone as $zoneNode) {
        if ($zoneNode["destination"] == $destination) {
            $zone = (string) $zoneNode;
            break;
        }
    }
    return $zone;
}

function getTariff($client, $zone, $tariffs) {
    $tariff = null;
    foreach ($tariffs->Tariff as $tariffNode) {
        if ($tariffNode["client"] == $client && $tariffNode["zone"] == $zone) {
            $tariff = (float) $tariffNode;
            break;
        }
    }
    return $tariff;
}

function getTax($client, $payer, $conditions) {
    $tax = null;
    foreach ($conditions->Tax as $taxNode) {
        if ($taxNode["client"] == $client && $taxNode["payer"] == $payer) {
            $tax = (float) $taxNode;
            break;
        }
    }
    return $tax;
}

function calculateHT($packages, $weight, $tariff, $tax) {
    $packageCost = (float) $packages;
    $weightCost = (float) $weight;
    return $packageCost + $weightCost + $tariff + $tax;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accueil</title>
</head>
<body>
    <h1>Page d'accueil</h1>

    <form method="POST" action="">
        <!-- Vos champs de formulaire ici -->
        <label for="client">Client :</label>
        <input type="text" id="client" name="client">
        
        <label for="destination">Destination :</label>
        <input type="text" id="destination" name="destination">
        
        <label for="packages">Nombre de colis :</label>
        <input type="text" id="packages" name="packages">
        
        <label for="weight">Poids :</label>
        <input type="text" id="weight" name="weight">
        
        <label for="payer">Payeur :</label>
        <input type="text" id="payer" name="payer">
        
        <input type="submit" value="Calculer">
    </form>
    
    <!-- Le reste de votre code HTML -->
</body>
</html>

