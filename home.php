<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="utf-8">
    <title>Vluchten</title>
    <link href="styles.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>

<body>

    <!-- navbar -->
    <?php
    require 'includes/dbconnect.php';

    session_start();
    if (!isset($_SESSION['loggedin'])) {
        header('Location: index.php');
        exit;
    }
    include 'includes/nav.php';
    ?>

    <!-- toon vluchten -->
    <section class="toon_vluchten">
        <h1><i class="fa-solid fa-plane-departure"></i> Vluchten</h1>

        <input type="text" class="search_field" placeholder="Zoek naar..." onkeyup="searchTable()">

        <?php
        // Bericht na succesvol boeken
        if (isset($_SESSION['success'])) {
            echo '<p class="success_message">' . $_SESSION['success'] . '</p>';
            unset($_SESSION['success']);
        }
        ?>

        <div class="table-container">

            <?php
            $sql = "SELECT * FROM Vluchten ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='vluchten_tabel'>
                    <tr class='sticky'>
                        <th>ID</th>
                        <th>Vluchtnummer</th>
                        <th>Vliegtuig Type</th>
                        <th>Vertrek Tijd</th>
                        <th>Aankomst Tijd</th>
                        <th>Vertrek Luchthaven</th>
                        <th>Aankomst Luchthaven</th>
                        <th>Alternatieve Luchthaven</th>
                        <th>Piloot</th>
                        <th>Copiloot</th>
                        <th>Aantal Passagiers</th>
                        <th>Aantal Stewardessen</th>
                        <th>Cargo Lading</th>
                        <th>Aantal Grondpersoneel</th>
                        <th>Bewerken</th>
                    </tr>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['vluchtnummer']}</td>
                        <td>{$row['vliegtuig_type']}</td>
                        <td>{$row['vertrek_tijd']}</td>
                        <td>{$row['aankomst_tijd']}</td>
                        <td>{$row['vertrek_luchthaven']}</td>
                        <td>{$row['aankomst_luchthaven']}</td>
                        <td>{$row['alternatieve_luchthaven']}</td>
                        <td>{$row['piloot1']}</td>
                        <td>{$row['piloot2']}</td>
                        <td>{$row['aantal_passagiers']}</td>
                        <td>{$row['aantal_stewardessen']}</td>
                        <td>{$row['cargo_lading_kg']}</td>
                        <td>{$row['grondpersoneel_aantal']}</td>
                        <td class='delete_flight_td'>
                            <form action='process/delete_flight.php' method='post'>
                                <input type='hidden' name='flight_id' value='{$row['id']}'>
                                <button type='submit' onclick=\"return confirm('Weet je zeker dat je deze vlucht wilt verwijderen?');\">
                                    <i class='fa-solid fa-trash'></i></button>
                            </form>
                        </td>
                      </tr>";
                }
                echo "</table>";
            } else {
                echo "Geen vluchten gevonden";
            }
            ?>
        </div>
    </section>

    <!-- boek vluchten -->
    <section class="boek_vlucht">

        <form action="process/boek_vlucht.php" method="post" class="flightForm">
            <h2><i class="fa-solid fa-plane-up"></i> Vlucht Toevoegen</h2>

            <label for="vertrek_tijd">Vertrek Datum</label>
            <input type="datetime-local" name="vertrek_tijd" id="vertrek_tijd" class="vertrek_tijd" required><br>

            <label for="aankomst_tijd">Aankomst Datum</label>
            <input type="datetime-local" name="aankomst_tijd" id="aankomst_tijd" required><br>

            <label for="vertrek_luchthaven">Vertrek Luchthaven</label>
            <select class="luchthavens_select" id="vertrek_luchthaven" name="vertrek_luchthaven" required>
                <option value="Rotterdam Airport" selected>Rotterdam Airport</option>
            </select><br>

            <label for="aankomst_luchthaven">Aankomst Luchthaven</label>
            <select class="luchthavens_select" id="aankomst_luchthaven" name="aankomst_luchthaven" required>
                <option value="" selected disabled>Kies Aankomst luchthaven</option>
            </select><br>

            <label for="alternatieve_luchthaven">Alternatieve Luchthaven</label>
            <select class="luchthavens_select" id="alternatieve_luchthaven" name="alternatieve_luchthaven" required>
                <option value="" selected disabled>Kies Alternatieve luchthaven</option>
            </select><br>

            <label for="vliegtuig_type">Selecteer Vliegtuigtype</label>
            <select name="vliegtuig_type" id="vliegtuig_type" class="vliegtuigTypes" onchange="updatePassengerLimit()" required>
                <option value="" selected disabled>Selecteer Vliegtuigtype</option>
                <option value="A320" data-max-passengers="90">A320</option>
                <option value="Boeing 737-800" data-max-passengers="110">Boeing 737-800</option>
                <option value="ATR-72" data-max-passengers="70">ATR-72</option>
                <option value="Boeing 737-700">Boeing 737-700</option>
            </select><br>

            <label for="piloot1">Piloot</label>
            <select name="piloot1" id="piloot1" required>
                <option value="" selected disabled>Kies Piloot</option>
                <?php
                $sql = "SELECT naam FROM personeel WHERE afdeling = 'Piloten'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['naam'] . "'>" . $row['naam'] . "</option>";
                    }
                }
                ?>
            </select><br>

            <label for="piloot2">Copiloot</label>
            <select name="piloot2" id="piloot2" required>
                <option value="" selected disabled>Kies Copiloot</option>
                <?php
                $sql = "SELECT naam FROM personeel WHERE afdeling = 'Piloten'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['naam'] . "'>" . $row['naam'] . "</option>";
                    }
                }
                ?>
            </select><br>

            <div class="passagiers">
                <label for="aantal_passagiers">Aantal Passagiers</label>
                <input type="number" name="aantal_passagiers" id="aantal_passagiers" value="0" class="aantal_passagiers"><br>
            </div>

            <div class="cargo">
                <label for="cargo_lading_kg">Cargo Lading (kg)</label>
                <input type="number" name="cargo_lading_kg" id="cargo_lading_kg" value="0" class="cargo_lading"><br>
            </div>

            <input type="submit" value="Toevoegen">
        </form>

    </section>

    <footer>
        <p>© 2024 MboAir</p>
    </footer>

    <script src="js/script.js"></script>
    <script src="js/airports_list.js"></script>
</body>

</html>

<?php
$conn->close();
?>