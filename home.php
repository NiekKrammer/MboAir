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
                        <th>Vliegtuig Type</th>
                        <th>Vertrek Tijd</th>
                        <th>Aankomst Tijd</th>
                        <th>Vertrek Luchthaven</th>
                        <th>Aankomst Luchthaven</th>
                        <th>Alternatieve Luchthaven</th>
                        <th>Piloot 1</th>
                        <th>Piloot 2</th>
                        <th>Aantal Passagiers</th>
                        <th>Aantal Stewardessen</th>
                        <th>Cargo Lading (kg)</th>
                        <th>Aantal Grondpersoneel</th>
                    </tr>";
				while ($row = $result->fetch_assoc()) {
					echo "<tr>
                        <td>{$row['id']}</td>
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
                        <td>2</td>
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

		<?php
		// succes message
		if (isset($_SESSION['success'])) {
			echo '<p class="success_message">' . $_SESSION['success'] . '</p>';
			unset($_SESSION['success']);
		}
		?>

		<form action="process/boek_vlucht.php" method="post">
			<h2><i class="fa-solid fa-plane-up"></i> Vlucht Toevoegen</h2>
			<label for="vertrek_tijd">Vertrek Datum</label>
			<input type="datetime-local" name="vertrek_tijd" class="vertrek_tijd" required><br>
			<label for="aankomst_tijd">Aankomst Datum</label>
			<input type="datetime-local" name="aankomst_tijd" required><br>
			<label for="vertrek_luchthaven">Vertrek Luchthaven</label>
			<input type="text" name="vertrek_luchthaven" required><br>
			<label for="aankomst_luchthaven">Aankomst Luchthaven</label>
			<input type="text" name="aankomst_luchthaven" required><br>
			<label for="alternatieve_luchthaven">Alternatieve Luchthaven</label>
			<input type="text" name="alternatieve_luchthaven"><br>
			<label for="alternatieve_luchthaven">Selecteer Vliegtuigtype</label>
			<select name="vliegtuig_type" class="vliegtuigTypes">
				<option value="A320">A320</option>
				<option value="Boeing 737-800">Boeing 737-800</option>
				<option value="ATR-72">ATR-72</option>
				<option value="Boeing 737-700">Boeing 737-700</option>
			</select><br>
			<label for="piloot1">Piloot</label>
			<input type="text" name="piloot1" required><br>
			<label for="piloot2">Copiloot</label>
			<input type="text" name="piloot2" required><br>
			<label for="aantal_passagiers">Aantal Passagiers</label>
			<input type="number" name="aantal_passagiers" value="0"><br>
			<label for="cargo_lading_kg" class="cargo_lading">Cargo Lading (kg)</label>
			<input type="number" name="cargo_lading_kg" class="cargo_lading">
			<input type="submit" value="Toevoegen">
		</form>

	</section>

	<script>
		// Toon/verberg cargo lading (kg) veld
		const vliegtuigTypes = document.querySelector('.vliegtuigTypes');
		const cargo_lading_input = document.querySelectorAll('.cargo_lading');

		vliegtuigTypes.addEventListener('change', function handleChange(event) {
			const selectedValue = event.target.value;
			cargo_lading_input.forEach(function(field) {
				if (selectedValue === 'Boeing 737-700') {
					field.style.display = 'block';
				} else {
					field.style.display = 'none';
				}
			});
		});

		// Vertrek moet tussen 06:00 uur en 16:00 uur zijn
		const vertrekTijd = document.querySelector(".vertrek_tijd");

		vertrekTijd.addEventListener("input", function() {
			let selectedTime = vertrekTijd.value;
			let minTime = "06:00";
			let maxTime = "16:00";

			if (selectedTime < minTime || selectedTime > maxTime) {
				vertrekTijd.setCustomValidity("Tijd moet tussen 06:00 en 16:00 liggen.");
			} else {
				vertrekTijd.setCustomValidity("");
			}
		});
	</script>

	<footer>
		© 2024 MboAir
	</footer>
</body>

</html>