<?php
// Récupérer les données envoyées par le formulaire
$client = $_POST['client'];
$destination = $_POST['destination'];
$packages = $_POST['packages'];
$weight = $_POST['weight'];
$payer = $_POST['payer'];

// Informations de connexion à la base de données
$host = "localhost"; // Remplacez par l'adresse de votre serveur MySQL
$username = "root"; // Remplacez par votre nom d'utilisateur MySQL
$password = ""; // Remplacez par votre mot de passe MySQL
$database = "votre_base_de_donnees"; // Remplacez par le nom de votre base de données

// Connexion à la base de données
$conn = new mysqli($host, $username, $password, $database);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// Utilisez les requêtes SQL pour effectuer les calculs nécessaires
$zone = getZone($destination, $conn);
$tariff = getTariff($client, $zone, $conn);
$tax = getTax($client, $payer, $conn);
$total = calculateHT($packages, $weight, $tariff, $tax);

// Afficher le résultat
echo "Le montant HT est : " . $total;

// Fonction pour obtenir la zone en fonction de la destination
function getZone($destination, $conn) {
    $query = "SELECT zone FROM localite WHERE destination = '$destination'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['zone'];
    }
    return null;
}

// Fonction pour obtenir le tarif en fonction du client et de la zone
function getTariff($client, $zone, $conn) {
    $query = "SELECT tariff FROM tarif WHERE client = '$client' AND zone = '$zone'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return (float) $row['tariff'];
    }
    return null;
}

// Fonction pour obtenir la taxe en fonction du client et du payeur
function getTax($client, $payer, $conn) {
    $query = "SELECT tax FROM conditiontaxation WHERE client = '$client' AND payer = '$payer'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return (float) $row['tax'];
    }
    return null;
}

// Fonction pour calculer le montant HT
function calculateHT($packages, $weight, $tariff, $tax) {
    $packageCost = (float) $packages;
    $weightCost = (float) $weight;
    return $packageCost + $weightCost + $tariff + $tax;
}

// Fermer la connexion à la base de données
$conn->close();
?>
