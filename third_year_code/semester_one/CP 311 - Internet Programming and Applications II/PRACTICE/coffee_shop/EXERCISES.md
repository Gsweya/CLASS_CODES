# Coffee Shop Exercises

Work from top to bottom. Each task says **what to build**, **which files to touch**, and **how to check** it worked.
Hints are hidden. Try for 10 minutes before you open one.

Tip: commit before each exercise (`git commit -am "before exercise 5"`), so you can always go back.

---

## Level 1: XML by hand (no PHP yet)

### 1. Add a drink by hand
Open `data/menu.xml` and add a **Hot Chocolate** (id `d7`, category `coffee`, 4000 TZS) by copying an existing `<item>`.
**Check:** refresh `index.php` and the new drink appears.

### 2. Break the rules on purpose
In your new item, change the price to `free`, then run:
```bash
cd data && xmllint --noout --schema menu.xsd menu.xml
```
Read the error, then fix it. Try two more breaks, then undo them:
- give two items the same `id`
- set `category="pizza"`

**Question:** which of these breaks would a **DTD** also catch? Which ones need an **XSD**?
<details><summary>Answer</summary>
A DTD can catch the duplicate id (if `id` is declared as type `ID`) and the wrong category (with an enumeration such as <code>(coffee|tea|…)</code>). Only an XSD can catch <code>free</code>, because a DTD cannot say "this must be a number".
</details>

### 3. Change the printable menu (XSLT)
In `data/menu.xsl`:
- sort the drinks by **name** instead of price
- show the food prices in **bold**

**Check:** open `print_menu.php`, and also open `data/menu.xml` directly in the browser.

### 4. A "NEW" label
Allow an **optional** attribute `new="true"` on `<item>`, and show a "NEW" tag for it on the printable menu.
**Files:** `menu.xsd` (allow the attribute), `menu.xml` (use it once), `menu.xsl` (show it).
<details><summary>Hint</summary>

XSD, inside `itemType`: `<xs:attribute name="new" type="xs:boolean" use="optional"/>`
XSL: `<xsl:if test="@new = 'true'"><span class="tag">NEW</span></xsl:if>`
</details>

---

## Level 2: OOP

### 5. Encapsulation: a drink can't be a pastry
Right now `admin.php` lets you save a **drink** in the **pastry** category.
Make the `Drink` constructor refuse that. Allowed drink categories: coffee, tea, juice. Do the same for `Food` (pastry, snack).
**Files:** `classes/Drink.php`, `classes/Food.php`
**Check:** in `admin.php`, choose Drink + Pastry. You should see your error message.
<details><summary>Hint</summary>

```php
private const CATEGORIES = ['coffee', 'tea', 'juice'];
// in the constructor, BEFORE parent::__construct(...)
if (!in_array($category, self::CATEGORIES)) {
    throw new InvalidArgumentException("A drink must be coffee, tea or juice.");
}
```
</details>

### 6. Inheritance: sell merchandise
The shop wants to sell mugs and bags of coffee beans. Add a third child class, **`Merchandise extends MenuItem`**:
- `type()` returns `'merch'`
- it has a private `int $stock`, saved in the XML as `<stock>12</stock>`
- `badge()` returns `"Only 3 left"` when stock is under 5, `"Sold out"` when it is 0, and `''` otherwise

**Files:** new `classes/Merchandise.php`, `bootstrap.php` (require it), `MenuRepository::makeItem()` (create it from XML), `menu.xsd` (allow `merch`, the `<stock>` element, ids starting with `m`, and a `merch` category), `menu.xml` (add 2 items).
**Check:** the items show on the menu with the right badge, and `xmllint` still says "validates".
<details><summary>Hint for the XSD</summary>

- `itemKind`: add `<xs:enumeration value="merch"/>`
- `categoryType`: add `<xs:enumeration value="merch"/>`
- `idType` pattern: `[dfm][0-9]+`
- inside `<xs:choice>`: `<xs:element name="stock" type="xs:nonNegativeInteger"/>`
</details>

### 7. Interface: happy hour
Create an interface `Discountable` with `public function discountedPrice(): float;`.
Make **Food** implement it: 20% off from 16:00 onwards (`date('H') >= 16`).
On `index.php`, if `$item instanceof Discountable` and the price is lower, show the old price crossed out (`<s>2,500 TZS</s>`) next to the new one.
**Extra:** make the cart and the order use the discounted price too.
<details><summary>Hint</summary>

```php
interface Discountable
{
    public function discountedPrice(): float;
}

class Food extends MenuItem implements Discountable
{
    public function discountedPrice(): float
    {
        if ((int) date('H') >= 16) {
            return $this->getPrice() * 0.8;
        }
        return $this->getPrice();
    }
}
```
</details>

### 8. A new repository method: count today's orders
Give `OrderRepository` a method `countToday(): int` that counts the orders whose `date` starts with today's date.
Show "Orders today: N" on `orders.php`.
<details><summary>Hint</summary>

XPath: `count(//order[starts-with(@date, '2026-11-26')])`. Build the date with `date('Y-m-d')`.
</details>

---

## Level 3: More XML tools

### 9. XPath: cheap items
Add `MenuRepository::cheaperThan(float $max): array` using the XPath `//item[price < 2000]`.
Add a chip "Under 2,000" to `index.php` that uses it, for example `index.php?max=2000`.

### 10. XPath: best seller
Add `OrderRepository::bestSeller(): string` that returns the name of the item with the biggest total `qty`.
**Hint:** loop over the menu ids and use `sum(//line[@item='d1']/@qty)` for each one.

### 11. Case-insensitive search
Searching "juma" on `orders.php` finds nothing, because XPath `contains()` is case-sensitive.
Fix it with XPath's `translate()` function, which can turn uppercase into lowercase.
<details><summary>Hint</summary>

```
//order[contains(translate(@customer, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), 'juma')]
```
Lower-case the search text with `strtolower()` before you put it in the query.
</details>

### 12. DOM: delete an item
Add a "Delete" button to each item on `admin.php` (or on the menu) that removes the `<item>` from `menu.xml`.
**Hint:** `DOMXPath::query("//item[@id='d3']")->item(0)`, then `$node->parentNode->removeChild($node)`, then `$doc->save(...)`.
Check the id with `preg_match` first, as `findById()` does.

### 13. XMLReader: read a big file
Write `tools/count_orders.php` that counts the orders in `orders.xml` with **XMLReader**, reading one node at a time, without loading the whole file.
Then make a fake file with 50,000 orders (write a small script to generate it) and compare the memory use with SimpleXML (`memory_get_peak_usage()`).
<details><summary>Hint</summary>

```php
$reader = new XMLReader();
$reader->open('../data/orders.xml');
$count = 0;
while ($reader->read()) {
    if ($reader->nodeType === XMLReader::ELEMENT && $reader->name === 'order') {
        $count++;
    }
}
$reader->close();
echo $count;
```
</details>

### 14. A DTD for orders.xml
Write `data/orders.dtd` (an **external** DTD) and link it from `orders.xml` with `<!DOCTYPE orders SYSTEM "orders.dtd">`.
Then run `xmllint --noout --valid orders.xml`.
**Question:** what can't your DTD check that an XSD could?

### 15. JSON vs XML
Create `export.php?format=json` and `export.php?format=xml`, both returning the whole menu.
- JSON: build arrays from the objects, then `json_encode($data, JSON_PRETTY_PRINT)`
- XML: use each object's `toXml()`

Compare the two outputs. Which is shorter? Which can be validated by a schema?

### 16. An XSD for the receipt
Write `data/receipt.xsd` for the XML that `receipt.php` produces, then validate a saved receipt with `xmllint`.

---

## Level 4: Build your own

Use the same structure: an abstract parent, 2-3 children, one interface, repositories that are the only code touching XML, an XSD, and an XSLT report.

| Project | XML files | OOP idea | XML twist |
|---------|-----------|----------|-----------|
| **Library** | `books.xml`, `loans.xml` | `LibraryItem` → `Book`, `EBook`, `Magazine`, plus a `Borrowable` interface | XSLT catalogue sorted by author, XPath "overdue loans" |
| **Bus tickets** | `routes.xml`, `bookings.xml` | `Seat` encapsulation: no double booking | XSD for times (`xs:time`), XMLWriter e-ticket |
| **Student results** | `results.xml` | `Assessment` → `Test`, `Exam`, `Project` | XPath `sum()` for averages, XSLT report card |
| **News reader** | any RSS file (`.xml`) | `FeedItem` objects | RSS is real-world XML: read `<channel><item><title>` with SimpleXML |
| **Pharmacy stock** | `medicines.xml` | `Medicine` → `Tablet`, `Syrup`, plus an `Expirable` interface | XSD `xs:date` for expiry, XPath "expires this month" |

**News reader starter:** save this as `feed.xml` and read it with `simplexml_load_file('feed.xml')->channel->item`:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
  <channel>
    <title>Campus News</title>
    <item><title>Exams start Monday</title><link>https://example.com/1</link><pubDate>Mon, 30 Nov 2026 08:00:00 +0300</pubDate></item>
    <item><title>Library open late</title><link>https://example.com/2</link><pubDate>Tue, 01 Dec 2026 08:00:00 +0300</pubDate></item>
  </channel>
</rss>
```
