<?php
session_start();
include_once '../includes/dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Genereer random vluchtnummer
    function RandomVluchtnummer($length = 8) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    $vluchtnummer = RandomVluchtnummer(8);
    $vertrek_tijd = mysqli_real_escape_string($conn, $_POST['vertrek_tijd']);
    $aankomst_tijd = mysqli_real_escape_string($conn, $_POST['aankomst_tijd']);
    $vertrek_luchthaven = mysqli_real_escape_string($conn, $_POST['vertrek_luchthaven']);
    $aankomst_luchthaven = mysqli_real_escape_string($conn, $_POST['aankomst_luchthaven']);
    $alternatieve_luchthaven = mysqli_real_escape_string($conn, $_POST['alternatieve_luchthaven']);
    $vliegtuig_type = mysqli_real_escape_string($conn, $_POST['vliegtuig_type']);
    $piloot1 = mysqli_real_escape_string($conn, $_POST['piloot1']);
    $piloot2 = mysqli_real_escape_string($conn, $_POST['piloot2']);
    $aantal_passagiers = intval($_POST['aantal_passagiers']);
    $cargo_lading_kg = intval($_POST['cargo_lading_kg']);

    // bereken aantal stewardessen gebaseerd op het aantal passagiers
    $aantal_stewardessen = ceil($aantal_passagiers / 60);

    $stmt = $conn->prepare("INSERT INTO vluchten (vluchtnummer, vertrek_tijd, aankomst_tijd, vertrek_luchthaven, aankomst_luchthaven, alternatieve_luchthaven, vliegtuig_type, piloot1, piloot2, aantal_passagiers, cargo_lading_kg, aantal_stewardessen) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        // Correct bind_param call
        $stmt->bind_param("sssssssssiii", $vluchtnummer, $vertrek_tijd, $aankomst_tijd, $vertrek_luchthaven, $aankomst_luchthaven, $alternatieve_luchthaven, $vliegtuig_type, $piloot1, $piloot2, $aantal_passagiers, $cargo_lading_kg, $aantal_stewardessen);

        if ($stmt->execute()) {
            $_SESSION['success'] = '<i class="fa-solid fa-circle-check"></i> Vlucht succesvol toegevoegd!';
        } else {
            $_SESSION['success'] = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: Unable to prepare statement.";
    }
} else {
    echo "Geen formuliergegevens ontvangen.";
}

$conn->close();
header("Location: ../home.php");
exit;
?>
