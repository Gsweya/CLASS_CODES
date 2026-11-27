<?php
// includes/header.php
// Unganisha faili la ulinzi kulingana na wapi ukurasa ulipo
if (file_exists('includes/auth.php')) {
    require_once 'includes/auth.php';
} else {
    require_once '../../includes/auth.php';
}

// Lensesha ulinzi: Kama mtu hajalog-in, itamfukuza hapa hapa!
check_authenticated();
?>

<!DOCTYPE html>
<html lang="sw">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMS - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        /* Urembo wa Ziada wa Neumorphic Dashboard */
        .dashboard-layout {
            display: flex;
            min-height: 100vh;
            width: 100%;
            background-color: var(--bg-color);
        }
        .main-content {
            flex: 1;
            padding: 30px;
            transition: all 0.4s ease;
        }
        .welcome-box {
            padding: 25px;
            border-radius: 20px;
            box-shadow: var(--shadow-out);
            margin-bottom: 30px;
        }
        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin-bottom: 30px;
        }
        .stats-card {
            padding: 25px;
            border-radius: 20px;
            box-shadow: var(--shadow-out);
            text-align: center;
        }
        .stats-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #1171ff;
        }
    </style>
</head>
<body class="light-mode">
    <div class="dashboard-layout">