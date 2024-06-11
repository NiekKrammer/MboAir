<?php
include_once '../includes/dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vertrek_tijd = mysqli_real_escape_string($conn, $_POST['vertrek_tijd']);
    $aankomst_tijd = mysqli_real_escape_string($conn, $_POST['aankomst_tijd']);
    $vertrek_luchthaven = mysqli_real_escape_string($conn, $_POST['vertrek_luchthaven']);
    $aankomst_luchthaven = mysqli_real_escape_string($conn, $_POST['aankomst_luchthaven']);
    $alternatieve_luchthaven = mysqli_real_escape_string($conn, $_POST['alternatieve_luchthaven']);
    $vliegtuig_type = mysqli_real_escape_string($conn, $_POST['vliegtuig_type']);
    $piloot1 = mysqli_real_escape_string($conn, $_POST['piloot1']);
    $piloot2 = mysqli_real_escape_string($conn, $_POST['piloot2']);
    $aantal_passagiers = intval($_POST['aantal_passagiers']);
    
    // Check if cargo_lading_kg is set and not empty, else set to null
    if (isset($_POST['cargo_lading_kg']) && $_POST['cargo_lading_kg'] !== '') {
        $cargo_lading_kg = intval($_POST['cargo_lading_kg']);
    } else {
        $cargo_lading_kg = null;
    }
    
    // Calculate the number of stewardesses
    $aantal_stewardessen = ceil($aantal_passagiers / 60);

    $stmt = $conn->prepare("INSERT INTO vluchten (vertrek_tijd, aankomst_tijd, vertrek_luchthaven, aankomst_luchthaven, alternatieve_luchthaven, vliegtuig_type, piloot1, piloot2, aantal_passagiers, cargo_lading_kg, aantal_stewardessen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        if ($cargo_lading_kg === null) {
            $stmt->bind_param("ssssssssisi", $vertrek_tijd, $aankomst_tijd, $vertrek_luchthaven, $aankomst_luchthaven, $alternatieve_luchthaven, $vliegtuig_type, $piloot1, $piloot2, $aantal_passagiers, $cargo_lading_kg, $aantal_stewardessen);
        } else {
            $stmt->bind_param("ssssssssiii", $vertrek_tijd, $aankomst_tijd, $vertrek_luchthaven, $aankomst_luchthaven, $alternatieve_luchthaven, $vliegtuig_type, $piloot1, $piloot2, $aantal_passagiers, $cargo_lading_kg, $aantal_stewardessen);
        }

        if ($stmt->execute()) {
            $_SESSION['success'] = "Vlucht succesvol toegevoegd!";
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

header("Location: ../home.php");
$conn->close();
?>
