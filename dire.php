<?php
$servername = "symfony-db"; 
$username = "root";       
$password = "PASSWORD";
$dbname = "chat";      

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['pseudo']) && isset($_GET['message'])) {
        if (strlen($_GET['pseudo']) <= 20 && strlen($_GET['message']) <= 1500) {
            $pseudo = $_GET['pseudo'];
            $message = $_GET['message'];
            $color = generateRandomColor(); 

            $sql = "INSERT INTO chat (pseudo, message, color) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$pseudo, $message, $color]); 

            echo "Message enregistré avec succès";
        } else {
            echo "Veuillez entrer un pseudo et un message plus court";
        }
    } else {
        echo "Paramètres pseudo et message manquants.";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;

function generateRandomColor() {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}
