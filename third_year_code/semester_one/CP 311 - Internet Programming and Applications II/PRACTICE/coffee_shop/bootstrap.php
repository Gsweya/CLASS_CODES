<?php
// =====================================================================
// bootstrap.php: loaded at the top of every page
// =====================================================================

session_start();                                  // needed for the cart
date_default_timezone_set('Africa/Dar_es_Salaam');

// Load every class (interface first, then parent, then children)
require_once __DIR__ . '/classes/Exportable.php';
require_once __DIR__ . '/classes/MenuItem.php';
require_once __DIR__ . '/classes/Drink.php';
require_once __DIR__ . '/classes/Food.php';
require_once __DIR__ . '/classes/Cart.php';
require_once __DIR__ . '/classes/Order.php';
require_once __DIR__ . '/classes/MenuRepository.php';
require_once __DIR__ . '/classes/OrderRepository.php';

const DATA_DIR = __DIR__ . '/data';

// The three objects every page can use
$menu   = new MenuRepository(DATA_DIR . '/menu.xml', DATA_DIR . '/menu.xsd');
$orders = new OrderRepository(DATA_DIR . '/orders.xml');
$cart   = new Cart();


// ---------------------------------------------------------------------
// Small helper functions
// ---------------------------------------------------------------------

// Escape text before printing it into HTML (stops broken pages and XSS)
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function money(float $amount): string
{
    return number_format($amount) . ' TZS';
}

// A one-time message shown on the next page ("Added to cart!")
function flash(string $message, string $type = 'ok'): void
{
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

function takeFlash(): ?array
{
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}
