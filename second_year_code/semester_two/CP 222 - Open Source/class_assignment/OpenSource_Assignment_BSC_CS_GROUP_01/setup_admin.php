<?php
// setup_admin.php
require_once 'config/db.php';

try {
    // 1. Hakikisha table ya users ipo salama
    $conn->exec("CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('Admin', 'Teacher', 'Staff') DEFAULT 'Teacher',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    // 2. Futa mtumiaji wa zamani mwenye email hii ili kuzuia mgongano
    $stmtDelete = $conn->prepare("DELETE FROM users WHERE email = 'admin@sims.ac.tz'");
    $stmtDelete->execute();

    // 3. Tengeneza hash mpya na thabiti ya password 'admin123'
    $plain_password = 'admin123';
    $hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);
    #kdkdkdkd
    // ddssds
    /* ddsd */

    
    // 4. Ingingize upya kwenye database
    $stmtInsert = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
    $stmtInsert->execute([
        'name' => 'Muksini Bushiri',
        'email' => 'admin@sims.ac.tz',
        'password' => $hashed_password,
        'role' => 'Admin'
    ]);

    echo "<h2 style='color: green; font-family: sans-serif; text-align: center; margin-top: 50px;'>
            Akaunti ya Admin Imewekwa Sawa kwa Mafanikio! 🎉<br>
            <span style='color: #555; font-size: 1.1rem;'>Sasa unaweza kurudi kwenye Login page na kuingia.</span>
          </h2>";

} catch (PDOException $e) {
    die("Kuna hitilafu imetokea wakati wa setup: " . $e->getMessage());
}
?>