
<?php
    // Connexion à la base de données
    $host = "http://localhost/phpmyadmin/index.php?route=/database/structure&db=projet+transport+besson+n2"; // Remplacez par l'adresse de votre serveur MySQL
    $username = "root"; // Remplacez par votre nom d'utilisateur MySQL
    $password = ""; // Remplacez par votre mot de passe MySQL
    $database = "projet transport besson n2"; // Remplacez par le nom de votre base de données


    $conn = mysqli_connect($host, $username, $password, $database);

    // Vérification de la connexion
    if (!$conn) {
        die("Erreur de connexion à la base de données : " . mysqli_connect_error());
    }

    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Effectuer le traitement des données (par exemple, enregistrement dans la base de données)

    // Fermer la connexion à la base de données
    mysqli_close($conn);
?>
