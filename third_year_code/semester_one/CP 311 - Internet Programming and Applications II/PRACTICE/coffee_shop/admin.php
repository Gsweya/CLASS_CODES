<?php
// =====================================================================
// admin.php: add a new item to menu.xml
// =====================================================================
// Two safety checks before anything is saved:
//   1. OOP:  the Drink / Food constructor refuses bad data (encapsulation)
//   2. XML:  MenuRepository::add() validates the whole file against menu.xsd

require __DIR__ . '/bootstrap.php';

$categories = [
    'drink' => ['coffee', 'tea', 'juice'],
    'food'  => ['pastry', 'snack'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type        = $_POST['type'] ?? '';
    $name        = $_POST['name'] ?? '';
    $price       = (float) ($_POST['price'] ?? 0);
    $category    = $_POST['category'] ?? '';
    $description = $_POST['description'] ?? '';
    $flag        = isset($_POST['flag']);   // the checkbox: hot or vegetarian

    try {
        // Make the right kind of OBJECT
        if ($type === 'drink') {
            $item = new Drink($menu->nextId('drink'), $name, $price, $category, $description, $flag);
        } elseif ($type === 'food') {
            $item = new Food($menu->nextId('food'), $name, $price, $category, $description, $flag);
        } else {
            throw new InvalidArgumentException("Choose drink or food.");
        }

        $menu->add($item);   // turns it into XML, checks the XSD, saves
        flash("Added " . e($item->getName()) . " (" . e($item->getId()) . ") to menu.xml.");
        redirect('index.php');
    } catch (Exception $error) {
        flash(e($error->getMessage()), 'error');
        redirect('admin.php');
    }
}

$pageTitle = 'Add item';
require __DIR__ . '/includes/header.php';
?>

<h1>Add a menu item</h1>
<p class="hint">The new item is written into <code>data/menu.xml</code> with DOMDocument and checked against <code>data/menu.xsd</code> before saving.</p>

<form method="post" class="panel form">
    <label for="type">Type</label>
    <select id="type" name="type">
        <option value="drink">Drink</option>
        <option value="food">Food</option>
    </select>

    <label for="name">Name</label>
    <input id="name" name="name" required>

    <label for="price">Price (TZS)</label>
    <input id="price" name="price" type="number" min="1" step="1" required>

    <label for="category">Category</label>
    <select id="category" name="category">
        <?php foreach ($categories as $kind => $list): ?>
            <optgroup label="<?= ucfirst($kind) ?>">
                <?php foreach ($list as $cat): ?>
                    <option value="<?= $cat ?>"><?= ucfirst($cat) ?></option>
                <?php endforeach; ?>
            </optgroup>
        <?php endforeach; ?>
    </select>

    <label for="description">Description</label>
    <input id="description" name="description">

    <label class="check"><input type="checkbox" name="flag" checked> Hot drink / Vegetarian food</label>

    <button type="submit">Save to menu.xml</button>
</form>

<?php require __DIR__ . '/includes/footer.php'; ?>
