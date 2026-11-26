<?php
// =====================================================================
// cart.php: see the cart, remove items, place the order
// =====================================================================
// Placing an order:
//   1. new Order($name)       -> the Order checks the name
//   2. $order->addLine(...)   -> one line per cart item
//   3. $orders->save($order)  -> the Order turns itself into XML (Exportable)

require __DIR__ . '/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'remove') {
        $cart->remove($_POST['id'] ?? '');
        flash("Item removed.");
        redirect('cart.php');
    }

    if ($action === 'clear') {
        $cart->clear();
        flash("Cart emptied.");
        redirect('cart.php');
    }

    if ($action === 'checkout') {
        try {
            if ($cart->isEmpty()) {
                throw new RuntimeException("Your cart is empty.");
            }

            $order = new Order($_POST['customer'] ?? '');

            foreach ($cart->getLines() as $itemId => $qty) {
                $item = $menu->findById($itemId);
                if ($item !== null) {            // skip items removed from the menu
                    $order->addLine($item, $qty);
                }
            }

            $orders->save($order);
            $cart->clear();

            flash("Asante, " . e($order->getCustomer()) . "! Order " . e($order->getId())
                . " placed. <a href=\"receipt.php?id=" . e($order->getId()) . "\">View the XML receipt</a>");
            redirect('orders.php');
        } catch (Exception $error) {
            flash(e($error->getMessage()), 'error');
            redirect('cart.php');
        }
    }
}

// Build the rows to show: turn each id in the cart into a MenuItem object
$rows = [];
$total = 0;
foreach ($cart->getLines() as $itemId => $qty) {
    $item = $menu->findById($itemId);
    if ($item === null) {
        continue;
    }
    $subtotal = $item->getPrice() * $qty;
    $total = $total + $subtotal;
    $rows[] = ['item' => $item, 'qty' => $qty, 'subtotal' => $subtotal];
}

$pageTitle = 'Cart';
require __DIR__ . '/includes/header.php';
?>

<h1>Your cart</h1>

<?php if (count($rows) === 0): ?>
    <p>The cart is empty. <a href="index.php">Go to the menu</a>.</p>
<?php else: ?>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th><th></th></tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?= e($row['item']->getName()) ?></td>
                    <td><?= $row['qty'] ?></td>
                    <td><?= money($row['item']->getPrice()) ?></td>
                    <td><?= money($row['subtotal']) ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="action" value="remove">
                            <input type="hidden" name="id" value="<?= e($row['item']->getId()) ?>">
                            <button class="link" type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr><th colspan="3">Total</th><th colspan="2"><?= money($total) ?></th></tr>
            </tfoot>
        </table>
    </div>

    <form method="post" class="panel">
        <input type="hidden" name="action" value="checkout">
        <label for="customer">Your name</label>
        <input id="customer" name="customer" required placeholder="e.g. Neema" maxlength="40">
        <button type="submit">Place order</button>
    </form>

    <form method="post">
        <input type="hidden" name="action" value="clear">
        <button class="link" type="submit">Empty the cart</button>
    </form>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
