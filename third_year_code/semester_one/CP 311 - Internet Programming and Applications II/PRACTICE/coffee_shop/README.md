# Kahawa Corner: a coffee shop web app (OOP + XML practice)

A small but complete web app: a menu, a cart, checkout, an orders page with sales numbers, an admin form and XML receipts.
There is **no database**. All the data lives in XML files, so every page practises one XML tool and the classes practise every OOP idea from `class_session/`.

When you're comfortable with the code, do the tasks in [`EXERCISES.md`](EXERCISES.md).

---

## Run it

```bash
cd "PRACTICE/coffee_shop"
php -S localhost:8000
```
Open <http://localhost:8000>. Press `Ctrl+C` in the terminal to stop.

**XAMPP:** copy the `coffee_shop` folder into `htdocs/` and open `http://localhost/coffee_shop/`.
The printable menu needs the `xsl` extension. In `php.ini`, remove the `;` in front of `extension=xsl` and restart Apache.

---

## Pages

| Page | What it does | XML tool it uses |
|------|--------------|------------------|
| `index.php` | Menu with category filter, add to cart | SimpleXML + XPath (read, filter) |
| `cart.php` | Cart, remove items, place order | DOMDocument (write `orders.xml`) |
| `orders.php` | All orders, sales stats, search by customer | XPath `count()`, `sum()`, `contains()` |
| `admin.php` | Add a new menu item | DOMDocument + **XSD validation** |
| `receipt.php?id=…` | Receipt for one order as XML | **XMLWriter** |
| `print_menu.php` | Printable HTML menu | **XSLT** on the server |
| `data/menu.xml` | Open it in the browser | **XSLT** in the browser (`<?xml-stylesheet?>`)* |

\* Some browsers are removing built-in XSLT support. If `data/menu.xml` shows plain XML instead of a styled menu, use `print_menu.php`, which runs the same XSLT on the server and always works.

---

## Where each OOP concept lives

| Concept | Where | What to look at |
|---------|-------|-----------------|
| Class / object | everywhere | `new Drink(...)`, `new Order(...)`, `new Cart()` |
| Inheritance | `classes/Drink.php`, `classes/Food.php` | both `extends MenuItem` and call `parent::__construct` |
| Abstract class | `classes/MenuItem.php` | `abstract type()`, `abstract badge()`, `abstract addExtraXml()` |
| Interface | `classes/Exportable.php` | `MenuItem` **and** `Order` both promise `toXml()` |
| Access modifiers | `classes/MenuItem.php` | `private $id`, `private $price`, `protected $name` |
| Encapsulation | `classes/Cart.php`, `classes/Order.php` | private data. `add()` refuses quantities over 10, and the Order refuses bad names |
| Polymorphism | `index.php` | one loop calls `$item->badge()`. Drinks say "Hot"/"Iced", food says "Vegetarian" |
| Class constant | `classes/Cart.php` | `private const MAX_PER_ITEM = 10` |

**How XML becomes objects:** `MenuRepository::makeItem()` reads one `<item>` node and returns a `Drink` or a `Food`.
**How objects become XML:** each object's `toXml()` builds its own element (the `Exportable` interface).
Only the two repository classes ever touch the XML files. The pages work with objects.

---

## XML toolbox: which tool for which job

| Tool | Job | Good for | Used in |
|------|-----|----------|---------|
| **SimpleXML** | read | quick, easy reading: `$item->name`, `$item['id']` | `MenuRepository`, `orders.php` |
| **XPath** | search and calculate | "find items where…", `count()`, `sum()`, `contains()` | `MenuRepository`, `OrderRepository` |
| **DOMDocument** | read **and** change | adding or removing nodes, then saving | `MenuRepository::add()`, `OrderRepository::save()` |
| **XMLWriter** | write only, start to finish | fast exports and big files | `receipt.php` |
| **XMLReader** | read only, one node at a time | huge files that don't fit in memory | Exercise 13 |
| **DTD** | rules (structure only) | simple rules, inside the XML file | `ASSIGNMENT_1/students.xml`, Exercise 14 |
| **XSD** | rules (structure **and** data types) | "price must be a number > 0" | `data/menu.xsd` |
| **XSLT** | transform XML → HTML/XML/text | reports, printable pages | `data/menu.xsl` |

### Validate the XML from the terminal

```bash
cd data
xmllint --noout --schema menu.xsd menu.xml   # prints "menu.xml validates"
xmllint --noout orders.xml                   # no output = well-formed
```

---

## Folder layout

```
coffee_shop/
├── bootstrap.php          loads classes, starts the session, creates $menu, $orders, $cart
├── index.php  cart.php  orders.php  admin.php  receipt.php  print_menu.php
├── style.css
├── classes/
│   ├── Exportable.php     interface
│   ├── MenuItem.php       abstract parent
│   ├── Drink.php  Food.php
│   ├── Cart.php  Order.php
│   └── MenuRepository.php  OrderRepository.php
├── includes/header.php  footer.php
└── data/
    ├── menu.xml   menu.xsd   menu.xsl
    └── orders.xml
```

## Reset the data

Using the app changes `data/menu.xml` and `data/orders.xml`. To go back to the original files:

```bash
git checkout -- data/
```
