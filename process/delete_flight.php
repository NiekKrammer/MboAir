<?php
session_start();
require '../includes/dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['flight_id'])) {
    $flightId = $_POST['flight_id'];
    $sql = "DELETE FROM Vluchten WHERE id = $flightId";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success'] = "<i class='fa-solid fa-trash-can' style='margin-right: 3px;'></i> Vlucht 'ID:$flightId' succesvol verwijderd.";
    } else {
        $_SESSION['error'] = "Fout bij verwijderen van vlucht: " . $conn->error;
    }
    
    header('Location: ../home.php'); 
    exit;
} else {
    header('Location: ../home.php'); 
    exit;
}

$conn->close();
?>
