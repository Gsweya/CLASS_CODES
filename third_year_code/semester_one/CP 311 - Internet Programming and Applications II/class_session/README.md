# CP 311 Class Session: OOP in PHP

Work through the lessons in order. Each file explains itself in its comments.

| # | File | Concept | Example |
|---|------|---------|---------|
| 1 | `01_objects.php` | Classes, objects, `$this`, constructor, constants, static, `clone` | `Student` |
| 2 | `02_inheritance.php` | `extends`, `parent::`, overriding, polymorphism | `Person` → `Student`, `Lecturer` |
| 3 | `03_access_modifiers.php` | `public`, `protected`, `private` | `Employee`, `Manager` |
| 4 | `04_encapsulation.php` | Private data + safe methods (getters) | `BankAccount` |
| 5 | `05_abstract_classes.php` | Abstract classes and methods | `Shape` → `Rectangle`, `Circle` |
| 6 | `06_interfaces.php` | Interfaces, `implements` | `PaymentMethod` → `MobileMoney`, `Card`, `Cash` |
| 7 | `07_all_together.php` | All of the above in one small system | University members and fees |

Notes and self-tests: [`CLAUDE_SUMMARIES/OOP_IN_PHP_STUDY_GUIDE.md`](CLAUDE_SUMMARIES/OOP_IN_PHP_STUDY_GUIDE.md)

## How to run

```bash
cd class_session
php 01_objects.php            # in the terminal
php -S localhost:8000         # or in the browser: http://localhost:8000/01_objects.php
```

On XAMPP, copy the folder into `htdocs/` and open it in the browser.

## How to study each lesson

1. Read the comment box at the top.
2. **Guess** what the output will be.
3. Run it and compare.
4. Break something on purpose and read the error. For example, remove `parent::__construct(...)`, or change `private` to `public`.
5. Answer the "Test yourself" questions in the study guide.

The lessons write types (`string $name`, `): float`). PHP does not require them. Section 0.5 of the study guide explains when to use them.

Tested on PHP 8.4. Works on PHP 8.0 and newer.
