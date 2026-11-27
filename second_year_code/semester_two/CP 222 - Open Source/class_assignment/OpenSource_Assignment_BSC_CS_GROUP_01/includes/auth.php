<?php
// includes/auth.php

// Hakikisha session imeanzishwa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * Kazi hii inalinda kurasa za ndani.
 * Mtu asiyelog-in akijaribu kuingia anafukuzwa kwenda login.php
 */
function check_authenticated() {
    if (!isset($_SESSION['user_id'])) {
        // Angalia kama tupo ndani ya folda la modules au la mzizi (root)
        if (file_exists('login.php')) {
            header("Location: login.php");
        } else {
            header("Location: ../../login.php");
        }
        exit();
    }
}

/**
 * Kazi hii inazuia mtu aliyelog-in tayari kurudi kwenye login page kimakosa
 */
function redirect_if_authenticated() {
    if (isset($_SESSION['user_id'])) {
        if (file_exists('index.php')) {
            header("Location: index.php");
        } else {
            header("Location: ../../index.php");
        }
        exit();
    }
}
?>