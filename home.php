<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Vluchten</title>
	<link href="style.css" rel="stylesheet" type="text/css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>

<body>

	<!-- navbar -->
	<?php
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

		<div class="table-container">

			<?php
			include_once 'includes/dbconnect.php';

			$sql = "SELECT * FROM Vluchten";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				echo "<table>
                    <tr>
                        <th>ID</th>
                        <th>Vertrek Tijd</th>
                        <th>Aankomst Tijd</th>
                        <th>Vertrek Luchthaven</th>
                        <th>Aankomst Luchthaven</th>
                        <th>Alternatieve Luchthaven</th>
                        <th>Vliegtuig Type</th>
                        <th>Piloot 1</th>
                        <th>Piloot 2</th>
                        <th>Aantal Passagiers</th>
                        <th>Aantal Stewardessen</th>
                        <th>Cargo Lading (kg)</th>
                        <th>Grondpersoneel Aantal</th>
                    </tr>";
				while ($row = $result->fetch_assoc()) {
					echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['vertrek_tijd']}</td>
                        <td>{$row['aankomst_tijd']}</td>
                        <td>{$row['vertrek_luchthaven']}</td>
                        <td>{$row['aankomst_luchthaven']}</td>
                        <td>{$row['alternatieve_luchthaven']}</td>
                        <td>{$row['vliegtuig_type']}</td>
                        <td>{$row['piloot1']}</td>
                        <td>{$row['piloot2']}</td>
                        <td>{$row['aantal_passagiers']}</td>
                        <td>{$row['aantal_stewardessen']}</td>
                        <td>{$row['cargo_lading_kg']}</td>
                        <td>{$row['grondpersoneel_aantal']}</td>
                      </tr>";
				}
				echo "</table>";
			} else {
				echo "Geen vluchten gevonden";
			}
			$conn->close();
			?>

		</div>
	</section>

	<!-- boek vluchten -->
	<section class="boek_vlucht">

		<form action="process/boek_vlucht.php" method="post">
			<h2><i class="fa-solid fa-plus"></i> Vlucht Toevoegen</h2>
			<label for="vertrek_tijd">Vertrek datum</label>
			<input type="datetime-local" id="vertrek_tijd" name="vertrek_tijd" required><br>
			<label for="aankomst_tijd">Aankomst datum</label>
			<input type="datetime-local" id="aankomst_tijd" name="aankomst_tijd" required><br>
			<label for="vertrek_luchthaven">Vertrek luchthaven</label>
			<input type="text" id="vertrek_luchthaven" name="vertrek_luchthaven" required><br>
			<label for="aankomst_luchthaven">Aankomst luchthaven</label>
			<input type="text" id="aankomst_luchthaven" name="aankomst_luchthaven" required><br>
			<label for="alternatieve_luchthaven">Alternatieve luchthaven</label>
			<input type="text" id="alternatieve_luchthaven" name="alternatieve_luchthaven"><br>
			<label for="vliegtuig_type">Vliegtuig Type</label>
			<input type="text" id="vliegtuig_type" name="vliegtuig_type" required><br>
			<label for="piloot1">Piloot 1:</label>
			<input type="text" id="piloot1" name="piloot1" required><br>
			<label for="piloot2">Piloot 2:</label>
			<input type="text" id="piloot2" name="piloot2" required><br>
			<label for="aantal_passagiers">Aantal passagiers</label>
			<input type="number" id="aantal_passagiers" name="aantal_passagiers"><br>
			<label for="aantal_stewardessen">Aantal stewardessen</label>
			<input type="number" id="aantal_stewardessen" name="aantal_stewardessen"><br>
			<label for="cargo_lading_kg">Cargo lading (kg)</label>
			<input type="number" id="cargo_lading_kg" name="cargo_lading_kg"><br>
			<label for="grondpersoneel_aantal">Aantal grondpersoneel</label>
			<input type="number" id="grondpersoneel_aantal" name="grondpersoneel_aantal" required><br>
			<input type="submit" value="Toevoegen">
		</form>

	</section>

</body>

</html>