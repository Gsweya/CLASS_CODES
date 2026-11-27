<?php
// config/db.php

$host = 'localhost';
$db_name = 'sims_db';
$username = 'root';
$password = ''; // Kama una password ya mysql, iweke kwenye config/db.local.php (git haitaipakia)

// Optional local override, never committed (see .gitignore): config/db.local.php
//   <?php $password = 'your-mysql-password';
if (file_exists(__DIR__ . '/db.local.php')) {
    require __DIR__ . '/db.local.php';
}

try {
    // Kutumia PDO (Njia salama na ya kisasa zaidi kwa Computer Science)
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    
    // USAHIHISHO: Hapa sasa hivi tumeweka "PDO::ERRMODE_EXCEPTION" kwa usahihi
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // Ikifeli ku-connect ionyeshe error
    die("Database Connection Failed: " . $e->getMessage());
}
?>