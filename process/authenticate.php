<?php 
session_start();

require '../includes/dbconnect.php';

if (isset($_POST['username'], $_POST['password'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $_SESSION['error'] = 'Vul zowel het gebruikersnaam- als wachtwoordveld in';
        header('Location: ../index.php');
        exit;
    }

    if ($stmt = $conn->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $password);
            $stmt->fetch();
            if (password_verify($_POST['password'], $password)) {
                session_regenerate_id();
                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $_POST['username'];
                $_SESSION['id'] = $id;
                header('Location: ../home.php');
                exit;
            }
        }
        $_SESSION['error'] = 'Ongeldige inloggegevens';
        header('Location: ../index.php');
        exit;

        $stmt->close();
    }
}
?>
