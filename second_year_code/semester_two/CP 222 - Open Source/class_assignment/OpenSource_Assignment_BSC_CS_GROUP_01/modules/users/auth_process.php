<?php
// modules/users/auth_process.php

// Anzisha session ili kuweza kutunza taarifa za aliyelog-in
session_start();

// Unganisha na faili la database connection
require_once '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Chukua data kutoka kwenye form na uzifanyie usafi (Sanitization)
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    if (!empty($email) && !empty($password)) {
        try {
            // Tafuta mtumiaji kwenye database kwa kutumia email yake
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            // Kama mtumiaji amepatikana, thibitisha password yake (iliyowekwa hash)
            if ($user && password_verify($password, $user['password'])) {
                
                // Tunza taarifa muhimu kwenye Session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role']; // Hapa tunasoma Role (Admin/Teacher/Staff)

                // Ukurasa wa kuelekea baada ya kufanikiwa (Dashboard)
                header("Location: ../../index.php");
                exit();
            } else {
                // Ikifeli, rudisha kwenye login page ikiwa na ujumbe wa makosa
                header("Location: ../../login.php?error=invalid_credentials");
                exit();
            }
        } catch (PDOException $e) {
            die("Error wa Authentication: " . $e->getMessage());
        }
    } else {
        header("Location: ../../login.php?error=empty_fields");
        exit();
    }
} else {
    // Kama mtu akijaribu kuingia faili hili bila kupitia fomu ya login
    header("Location: ../../login.php");
    exit();
}