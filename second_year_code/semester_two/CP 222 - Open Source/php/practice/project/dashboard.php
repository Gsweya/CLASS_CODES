<?php
    session_start();

    if(!isset($_SESSION['username'])){
        die("Access Denied");
    }

    echo "Welcome " . $_SESSION['username'];
?>
    <br>
    <a href="logout.php">Logout</a>