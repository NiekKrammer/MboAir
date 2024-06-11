<?php
include_once '../includes/dbconnect.php';

// Controleer of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Haal de gegevens van het formulier op en ontsnap ze
    $vertrek_tijd = mysqli_real_escape_string($conn, $_POST['vertrek_tijd']);
    $aankomst_tijd = mysqli_real_escape_string($conn, $_POST['aankomst_tijd']);
    $vertrek_luchthaven = mysqli_real_escape_string($conn, $_POST['vertrek_luchthaven']);
    $aankomst_luchthaven = mysqli_real_escape_string($conn, $_POST['aankomst_luchthaven']);
    $alternatieve_luchthaven = mysqli_real_escape_string($conn, $_POST['alternatieve_luchthaven']);
    $vliegtuig_type = mysqli_real_escape_string($conn, $_POST['vliegtuig_type']);
    $piloot1 = mysqli_real_escape_string($conn, $_POST['piloot1']);
    $piloot2 = mysqli_real_escape_string($conn, $_POST['piloot2']);
    $aantal_passagiers = intval($_POST['aantal_passagiers']);
    $aantal_stewardessen = intval($_POST['aantal_stewardessen']);
    $cargo_lading_kg = intval($_POST['cargo_lading_kg']);
    $grondpersoneel_aantal = intval($_POST['grondpersoneel_aantal']);

    // Bereid de SQL-instructie voor
    $stmt = $conn->prepare("INSERT INTO vluchten (vertrek_tijd, aankomst_tijd, vertrek_luchthaven, aankomst_luchthaven, alternatieve_luchthaven, vliegtuig_type, piloot1, piloot2, aantal_passagiers, aantal_stewardessen, cargo_lading_kg, grondpersoneel_aantal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Controleer of de voorbereiding is geslaagd
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssssssssiiii", $vertrek_tijd, $aankomst_tijd, $vertrek_luchthaven, $aankomst_luchthaven, $alternatieve_luchthaven, $vliegtuig_type, $piloot1, $piloot2, $aantal_passagiers, $aantal_stewardessen, $cargo_lading_kg, $grondpersoneel_aantal);

        // Voer de SQL-instructie uit
        if ($stmt->execute()) {
            echo "Nieuwe vlucht succesvol toegevoegd";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Sluit de statement
        $stmt->close();
    } else {
        echo "Error: Unable to prepare statement.";
    }
} else {
    echo "Geen formuliergegevens ontvangen.";
}

// Sluit de verbinding
$conn->close();
?>
