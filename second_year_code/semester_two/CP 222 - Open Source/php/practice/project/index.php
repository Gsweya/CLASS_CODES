<?php
    session_start();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['username'];
        $_SESSION['username'] = $username;

        header("Location: dashboard.php");
        exit();
    }
?>

<form method="POST">
    Username:
    <input type="text" name="username">
    <button>Login</login>
</form>