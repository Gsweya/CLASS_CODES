<?php
// =====================================================================
// index.php: the menu
// =====================================================================
// - Reads the menu from XML (MenuRepository gives us Drink/Food OBJECTS)
// - Filters by category (XPath inside MenuRepository::byCategory)
// - "Add to cart" goes through the Cart class (encapsulation)

require __DIR__ . '/bootstrap.php';

// ---------- 1. Handle the "Add to cart" form ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item = $menu->findById($_POST['id'] ?? '');
    $qty  = (int) ($_POST['qty'] ?? 1);

    try {
        if ($item === null) {
            throw new RuntimeException("That item is not on the menu.");
        }
        $cart->add($item->getId(), $qty);   // Cart checks the quantity rules
        flash("Added " . $qty . " × " . e($item->getName()) . " to your cart.");
    } catch (Exception $error) {
        flash(e($error->getMessage()), 'error');
    }

    redirect('index.php?category=' . urlencode($_POST['category'] ?? ''));
}

// ---------- 2. Get the items to show ----------
$category = $_GET['category'] ?? '';

if ($category === '') {
    $items = $menu->all();
} else {
    $items = $menu->byCategory($category);
}

$pageTitle = 'Menu';
require __DIR__ . '/includes/header.php';
?>

<h1>Our menu</h1>

<!-- Category filter -->
<div class="chips">
    <a href="index.php" class="chip <?= $category === '' ? 'active' : '' ?>">All</a>
    <?php foreach ($menu->categories() as $cat): ?>
        <a href="index.php?category=<?= e($cat) ?>" class="chip <?= $cat === $category ? 'active' : '' ?>"><?= e(ucfirst($cat)) ?></a>
    <?php endforeach; ?>
</div>

<div class="grid">
    <?php foreach ($items as $item): ?>
        <!--
          POLYMORPHISM: $item is sometimes a Drink, sometimes a Food.
          We call the same methods, and each class answers its own way.
        -->
        <article class="card">
            <div class="card-top">
                <span class="category"><?= e($item->getCategory()) ?></span>
                <?php if ($item->badge() !== ''): ?>
                    <span class="badge"><?= e($item->badge()) ?></span>
                <?php endif; ?>
            </div>
            <h2><?= e($item->getName()) ?></h2>
            <p class="desc"><?= e($item->getDescription()) ?></p>
            <div class="card-bottom">
                <strong><?= money($item->getPrice()) ?></strong>
                <form method="post">
                    <input type="hidden" name="id" value="<?= e($item->getId()) ?>">
                    <input type="hidden" name="category" value="<?= e($category) ?>">
                    <input type="number" name="qty" value="1" min="1" max="10" aria-label="Quantity">
                    <button type="submit">Add</button>
                </form>
            </div>
        </article>
    <?php endforeach; ?>
</div>

<?php if (count($items) === 0): ?>
    <p>No items in this category.</p>
<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>
