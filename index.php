<?php 
session_start();
if (isset($_SESSION['loggedin'])) {
	header('Location: home.php');
	exit;
}   
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	<link href="style.css" rel="stylesheet" type="text/css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

	<?php
	include 'includes/nav.php';
	?>

	<form action="process/authenticate.php" method="post" class="login_form">
		<img src="assets/user_icon.jpg">
		<h1>Login</h1>
		<?php
		// error message
		if (isset($_SESSION['error'])) {
			echo '<p class="error_message">' . $_SESSION['error'] . '</p>';
			unset($_SESSION['error']);
		}
		?>
		<input type="text" name="username" placeholder="Gebruikersnaam" required>
		<input type="password" name="password" placeholder="Wachtwoord" required>
		<input type="submit" value="Login">
	</form>


</body>

</html>