<?php
include('navigation.php');

// Charger le fichier XML des clients
$clients = simplexml_load_file('client.xml');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Vérifier si le client existe dans le fichier XML
    $clientExists = false;
    foreach ($clients->client as $client) {
        if (trim($client->nom) == $nom) {
            $clientExists = true;
            break;
        }
    }

    // Effectuer le traitement des données en fonction de l'existence du client
    if ($clientExists) {
        // Le client existe, effectuer le traitement supplémentaire
        // ...

        // Afficher un message de confirmation
        echo "Merci pour votre message, $nom!";
    } else {
        // Le client n'existe pas, afficher un message d'erreur
        echo "Le client $nom n'existe pas!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact</title>
</head>
<body>
    <h1>Contact</h1>

    <section id="contact">
        <h2>Contactez-nous</h2>
        
        <form id="contact-form" method="POST" action="">
            <div>
                <label for="name">Nom :</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="message">Message :</label>
                <textarea id="message" name="message" required></textarea>
            </div>
            <button type="submit">Envoyer</button>
        </form>
    </section>

<?php include('footer.php'); ?>
