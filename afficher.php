<?php
$servername = "symfony-db";
$username = "root";
$password = "PASSWORD";
$dbname = "chat";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT id, pseudo, message, color, date FROM chat ORDER BY id DESC LIMIT 10";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $messages = array_reverse($messages);
    
    $compteur = 0;

    foreach ($messages as $message) {
        $initiale = strtoupper($message['pseudo'][0]);
        $color = htmlspecialchars($message['color']);
        $class = ($compteur % 2 === 0) ? 'left-message' : 'right-message';
    
        echo "<div class='message-item $class'>";
        echo "<div class='profile-circle' style='background-color: $color;'>"; 
        echo $initiale . "</div>";
        
        if ($message['message'] == "wizz") {
            echo "<div class='message-text ' data-wizz='1' data-id='".$message['id']."'>";
        } else {
            echo "<div class='message-text'>"; 
        }
        
        echo '<span class="message-body">' . htmlspecialchars($message['message']) . '</span>';

        // Extraire uniquement l'heure à partir de la date
        $dateTime = new DateTime($message['date']);
        $time = $dateTime->format('H:i'); // Format de l'heure

        echo '<span class="message-timestamp">' . htmlspecialchars($time) . '</span>'; // Affiche uniquement l'heure
        echo "</div></div>";
    
        $compteur++;
    }

} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

$conn = null;
?>
