<?php
// =====================================================================
// orders.php: all orders + sales numbers
// =====================================================================
// - Numbers at the top come from XPath count() and sum()
// - The search box uses XPath contains()
// - The list is read with SimpleXML: $order['customer'], $order->line, ...

require __DIR__ . '/bootstrap.php';

$search = trim($_GET['customer'] ?? '');

if ($search === '') {
    $list = $orders->all();
} else {
    $list = $orders->byCustomer($search);
}

$stats = $orders->stats();

$pageTitle = 'Orders';
require __DIR__ . '/includes/header.php';
?>

<h1>Orders</h1>

<div class="stats">
    <div class="stat"><span><?= $stats['orders'] ?></span>orders</div>
    <div class="stat"><span><?= number_format($stats['revenue']) ?></span>TZS earned</div>
    <div class="stat"><span><?= $stats['drinks'] ?></span>drinks sold</div>
    <div class="stat"><span><?= $stats['food'] ?></span>food sold</div>
</div>

<form method="get" class="search">
    <input name="customer" value="<?= e($search) ?>" placeholder="Search by customer name">
    <button type="submit">Search</button>
    <?php if ($search !== ''): ?><a href="orders.php">Clear</a><?php endif; ?>
</form>

<?php if (count($list) === 0): ?>
    <p>No orders found.</p>
<?php endif; ?>

<?php foreach ($list as $order): ?>
    <!-- $order is a SimpleXMLElement: attributes with [ ], children with -> -->
    <article class="order">
        <div class="order-head">
            <strong><?= e($order['customer']) ?></strong>
            <span><?= e($order['date']) ?></span>
        </div>
        <ul>
            <?php foreach ($order->line as $line): ?>
                <li><?= e($line['qty']) ?> × <?= e($line) ?> <small>(<?= money((float) $line['price']) ?> each)</small></li>
            <?php endforeach; ?>
        </ul>
        <div class="order-foot">
            <strong><?= money((float) $order->total) ?></strong>
            <a href="receipt.php?id=<?= e($order['id']) ?>">XML receipt</a>
        </div>
    </article>
<?php endforeach; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
