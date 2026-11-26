<?php
// Shared top of every page. The page sets $pageTitle before including this.
$current = basename($_SERVER['SCRIPT_NAME']);
$flash = takeFlash();

$links = [
    'index.php'      => 'Menu',
    'cart.php'       => 'Cart (' . $cart->countItems() . ')',
    'orders.php'     => 'Orders',
    'admin.php'      => 'Add item',
    'print_menu.php' => 'Printable menu',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> - <?= e($menu->shopName()) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar">
    <a class="brand" href="index.php">☕ <?= e($menu->shopName()) ?></a>
    <nav>
        <?php foreach ($links as $file => $label): ?>
            <a href="<?= $file ?>" class="<?= $file === $current ? 'active' : '' ?>"><?= e($label) ?></a>
        <?php endforeach; ?>
    </nav>
</header>

<main>
<?php if ($flash): ?>
    <div class="flash <?= e($flash['type']) ?>"><?= $flash['message'] ?></div>
<?php endif; ?>
