# OOP in PHP: Study Guide (CP 311)

Each topic follows the same steps:

1. **In one line:** the idea in plain words
2. **Why:** the problem it solves
3. **Code:** the smallest example
4. **Run it:** the lesson file in `class_session/`
5. **Watch out:** common mistakes
6. **Test yourself:** answer first, then open the answer

Run a lesson from the `class_session/` folder with `php 01_objects.php`.

---

## 0. The big picture

OOP (Object Oriented Programming) means organising code around **things** (objects). Each thing keeps its own **data** (properties) and its own **actions** (methods).

The **four pillars** of OOP:

| Pillar | In one line | Lesson |
|--------|-------------|--------|
| Inheritance | A child class gets everything from a parent class | 2 |
| Encapsulation | Hide the data and change it only through safe methods | 4 |
| Abstraction | Say *what* must be done and let each class decide *how* | 5, 6 |
| Polymorphism | The same method call gives different results for different objects | 2, 5, 6 |

Access modifiers (lesson 3) are not a pillar. They are the **tool** that makes encapsulation work.

### Symbols you will see everywhere

| Symbol | Meaning | Example |
|--------|---------|---------|
| `new` | create an object | `$juma = new Student("Juma", 3);` |
| `->` | use an object's property or method | `$juma->name`, `$juma->introduce()` |
| `$this` | "this object", used inside the class | `$this->name = $name;` |
| `::` | use something that belongs to the class | `School::NAME` |
| `self::` | "this class", used inside the class | `self::$visitors` |
| `parent::` | "my parent class" | `parent::__construct($name, $email);` |

> Write `$this->name`, **not** `$this->$name`. There is only one `$`.

---

## 0.5 Side note: types are OPTIONAL

The lessons write types like `string $name` or `): float`. **PHP does not require them.** This also works:

```php
class Student {
    public $year;                                // no type
    function setYear($y) { $this->year = $y; }   // no types
}
```

Many lecture notes write PHP this way. Both styles run.

### What types do

They stop wrong data at the door:

```php
// WITHOUT types
$s->setYear("banana");    // accepted. $year is now "banana" and nobody complains

// WITH types:  public int $year;  function setYear(int $y)
$t->setYear("5");         // accepted, PHP turns "5" into 5
$t->setYear("banana");    // TypeError: must be of type int, string given
```

### Three levels

| Style | How you write it | `setYear("5")` / `setYear("banana")` |
|-------|------------------|--------------------------------------|
| No types | `function setYear($y)` | both accepted |
| Types | `function setYear(int $y)` | `"5"` accepted as `5`, `"banana"` gives an error |
| Strict | `declare(strict_types=1);` on the **first line** of the file + types | both give an error |

### Where a type can go

```php
class Account {
    private float $balance = 0;                       // 1. on a property
    public function deposit(float $amount): void {}   // 2. on a parameter, 3. on the return value
}
```

### Types you'll meet

| Type | Meaning |
|------|---------|
| `int`, `float`, `string`, `bool`, `array` | the basic types |
| a class or interface name, e.g. `PaymentMethod` | an object of that class or interface |
| `void` | the method returns nothing |
| `?string` | a string **or** `null` |
| `mixed` | anything |

### One trap

```php
class A { public $x; }       // no type: $x starts as null
class B { public int $x; }   // typed: reading $x before giving it a value is an Error
```

### When to use them

- **Use them** when the data has a clear kind (money, a year, a name), when other people will use your class, and in real projects such as Laravel.
- **You can skip them** to match your lecturer's style in an exam, or in a quick test script.

**Rule of thumb:** types are like seat belts. The car runs without them, but they help when something goes wrong.

<details><summary><b>Test yourself 0.5</b></summary>

1. Does `function add($a, $b) { return $a + $b; }` run? → Yes. Types are optional.
2. With `function f(int $x)`, what does `f("7")` do? And `f("seven")`? → `"7"` becomes `7` and is accepted. `"seven"` gives a TypeError.
3. What does `declare(strict_types=1);` do, and where does it go? → It turns off the automatic conversion, so `f("7")` fails too. It goes on the first line of the file.
4. What does `?int` mean? → An int or null.
</details>

---

## 1. Classes and Objects → `01_objects.php`

**In one line:** a **class** is a blueprint and an **object** is a real thing made from it.

**Why:** a university has 500 students. Write the plan "Student" once, then make as many students as you need.

**Code:**

```php
class Student
{
    public string $name;     // property (data)
    public int $year;

    public function __construct(string $name, int $year)   // runs on "new"
    {
        $this->name = $name;
        $this->year = $year;
    }

    public function introduce(): string                    // method (action)
    {
        return "Hi, I am " . $this->name;
    }
}

$juma = new Student("Juma", 3);   // create an object
echo $juma->introduce();          // use it with ->
```

**Remember:**
- Each object has **its own** data. Promoting Asha does not change Juma.
- The **constructor** `__construct` runs automatically when you use `new`.
- **Constants** (`const NAME = "UDOM";`) and **static** properties belong to the **class**, so there is one shared value. You use them with `::`, for example `School::NAME`.
- `$copy = $asha;` does **not** copy the object. Both names point to the same Asha. Use `clone $asha` to get a real copy.

<details><summary><b>Test yourself 1</b></summary>

1. Class vs object? → The class is the plan. The object is one thing made from the plan with `new`.
2. When does `__construct` run? → Automatically, when `new` creates the object.
3. `$a = new Student("X", 1); $b = $a; $b->name = "Y"; echo $a->name;` prints? → `Y`. `$a` and `$b` are the same object.
4. How do you read a constant `NAME` in class `School`? → `School::NAME`
</details>

---

## 2. Inheritance → `02_inheritance.php`

**In one line:** a **child** class `extends` a **parent** class and gets everything the parent has. Then it can add new things or override (replace) methods.

**Why:** Students and Lecturers both have a name and an email. Write that once in `Person`, and let both of them extend it.

**Test:** "A Student **is a** Person"? Yes, so inheritance fits. "A Car is an Engine"? No, so don't use inheritance there.

**Code:**

```php
class Person
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function describe(): string
    {
        return $this->name;
    }
}

class Student extends Person
{
    public string $programme;                      // ADD something new

    public function __construct(string $name, string $programme)
    {
        parent::__construct($name);                // let the parent set the name
        $this->programme = $programme;
    }

    public function describe(): string             // OVERRIDE the parent's method
    {
        return $this->name . " studies " . $this->programme;
    }
}
```

**Remember:**
- If the child has its own constructor, call `parent::__construct(...)`. **Forgetting it** is the #1 mistake.
- `parent::describe()` runs the parent's version of the method.
- A class can extend only **one** parent.
- `final class X` → nobody can extend X. `final public function y()` → children can't override `y()`.
- `$student instanceof Person` is `true`, because a Student **is a** Person.
- **Polymorphism:** put different people in one array, loop over it and call `describe()`. Each object uses its own version.

<details><summary><b>Test yourself 2</b></summary>

1. What is overriding? → The child writes a method with the same name as the parent's, which gives it new behaviour.
2. How does the child call the parent's constructor? → `parent::__construct(...)`
3. Can a class extend two classes? → No, only one. Use interfaces for "many".
4. What does `final` do? → On a class it stops extending. On a method it stops overriding.
</details>

---

## 3. Access Modifiers → `03_access_modifiers.php`

**In one line:** `public`, `protected` and `private` decide **who** can use a property or method.

| | inside the class | child class | outside code |
|---|:---:|:---:|:---:|
| `public` | ✅ | ✅ | ✅ |
| `protected` | ✅ | ✅ | ❌ |
| `private` | ✅ | ❌ | ❌ |

**Why:** some data must never be touched from outside, such as a PIN or a balance.

**Code:**

```php
class Employee
{
    public string $name;       // everyone
    protected float $salary;   // this class + children
    private string $pin;       // this class only
}

$e->name;     // OK
$e->salary;   // Error: Cannot access protected property Employee::$salary
$e->pin;      // Error: Cannot access private property Employee::$pin
```

**Remember:**
- Inside the class you can use **all** of them.
- A child class can use `protected` members, but **not** the parent's `private` ones.
- A method with no modifier is `public`.
- Methods can be private too, for small helpers that only the class uses.
- **Simple rule:** make properties `private` unless you have a reason not to.

<details><summary><b>Test yourself 3</b></summary>

1. Which modifier lets children use a member but hides it from outside? → `protected`
2. Can a child class use the parent's `private` property? → No.
3. What is the default modifier for a method? → `public`
</details>

---

## 4. Encapsulation → `04_encapsulation.php`

**In one line:** make the data **private** and change it only through **public methods that check the rules**.

**Why:** with a public balance, anyone can write `$account->balance = -50000;`. With encapsulation, the only way to change the balance is `deposit()` or `withdraw()`, and both of them check the amount first. Think of an ATM: you press buttons, you don't open the machine.

**Code:**

```php
class BankAccount
{
    private float $balance = 0;          // hidden

    public function getBalance(): float  // GETTER: read only
    {
        return $this->balance;
    }

    public function deposit(float $amount): void   // safe way to change it
    {
        if ($amount <= 0) {
            echo "Refused";
            return;
        }
        $this->balance = $this->balance + $amount;
    }
}
```

**Remember:**
- A **getter** (`getBalance()`) lets others read the value. A **setter** or action method (`deposit()`) changes it **after checking**.
- You don't need a setter for everything. There is no `setBalance()`, on purpose.
- **Access modifiers vs encapsulation:** modifiers are the *keywords*. Encapsulation is the *idea* of using them to protect data.

<details><summary><b>Test yourself 4</b></summary>

1. Two benefits of encapsulation? → It protects the data from wrong values, and it hides how the class works inside.
2. Why is there no `setBalance()`? → Money should change only through deposit and withdraw, because they check the rules.
3. What is a getter? → A public method that returns a private value.
</details>

---

## 5. Abstract Classes → `05_abstract_classes.php`

**In one line:** an **unfinished** parent class. You can't create it with `new`. It can force every child to write certain methods.

**Why:** every shape has an area, but each shape calculates it differently. `Shape` says "you must have `area()`", and each child writes its own formula.

**Code:**

```php
abstract class Shape
{
    abstract public function area(): float;   // no body, ends with ;

    public function describe(): string        // normal method, shared by all children
    {
        return "Area is " . $this->area();
    }
}

class Circle extends Shape
{
    private float $radius;

    public function __construct(float $radius)
    {
        $this->radius = $radius;
    }

    public function area(): float              // MUST write this
    {
        return 3.14159 * $this->radius * $this->radius;
    }
}
```

**Remember:**
- `new Shape()` → `Error: Cannot instantiate abstract class Shape`
- If a child forgets an abstract method, PHP gives a Fatal error.
- An abstract class **can** have properties, a constructor and normal methods.
- If a class has even one abstract method, the class must be `abstract`.

<details><summary><b>Test yourself 5</b></summary>

1. Can you write `new` on an abstract class? → No.
2. Does an abstract method have a body `{ }`? → No. It ends with `;`.
3. What must the child of an abstract class do? → Write every abstract method.
</details>

---

## 6. Interfaces → `06_interfaces.php`

**In one line:** a **promise**. It lists method names only, with no code inside them. A class that `implements` it promises to write those methods.

**Why:** a shop accepts mobile money, card and cash. They are very different, but they all **can** `pay()`.

**Code:**

```php
interface PaymentMethod
{
    public function pay(float $amount): string;   // name only
}

class Card implements PaymentMethod
{
    public function pay(float $amount): string    // keeps the promise
    {
        return "Paid " . $amount . " by card";
    }
}

function checkout(PaymentMethod $method, float $amount)   // accepts ANY payment method
{
    echo $method->pay($amount);
}
```

**Remember:**
- A class can `implements` **many** interfaces: `class MobileMoney implements PaymentMethod, Refundable`
- Interface methods are always `public`.
- Interfaces have **no properties**. They may have constants.
- `checkout(PaymentMethod $method)` accepts any class that implements `PaymentMethod`. To add bank transfer later, you add one new class and the checkout does not change.
- A class can do both: `class Student extends Member implements Payable`

<details><summary><b>Test yourself 6</b></summary>

1. Can an interface have method bodies? → No. It has method names only.
2. How many interfaces can a class implement? → As many as it needs.
3. What does `function f(PaymentMethod $p)` accept? → Any object whose class implements `PaymentMethod`.
</details>

---

## 7. Abstract class vs Interface (exam favourite)

| | Abstract class | Interface |
|---|---|---|
| Keyword | `abstract class` + `extends` | `interface` + `implements` |
| How many per class | only **one** | **many** |
| Methods with code | yes | no |
| Properties | yes | no (only constants) |
| Constructor | yes | no |
| Can use `new` on it | no | no |
| Relationship | **is a** (Circle *is a* Shape) | **can do** (Card *can* pay) |

**One-sentence answer:** use an **abstract class** when related classes share code, and an **interface** when different classes need the same ability.

---

## 8. Everything together → `07_all_together.php`

```
  Payable (interface)          Member (abstract class)
        ^                          ^            ^
        |                          |            |
        +-------- Student ---------+         Lecturer
```

- `Member` (abstract) has a `protected $name` and an abstract `role()`.
- `Student` extends `Member`, implements `Payable`, and keeps a **private** course list that only `addCourse()` can change. That method refuses a 4th course.
- `Lecturer` extends `Member`.
- One loop prints every badge (polymorphism). Another loop bills only the objects that are `instanceof Payable`.

Search the file for the labels `[ACCESS]`, `[ENCAPSULATION]`, `[INHERITANCE]` and so on.

**Exercise:** add a `Staff` class that extends `Member` and implements `Payable` (a 20,000 TZS parking fee). If the loops work without any change, you understand polymorphism.

---

## 9. Quick revision (cover the right column)

| Question | Answer |
|----------|--------|
| Keyword to create an object | `new` |
| "This object" inside a class | `$this` |
| Use something that belongs to the class | `ClassName::` / `self::` |
| Call the parent's constructor | `parent::__construct()` |
| Visible to children, hidden from outside | `protected` |
| Visible only inside its own class | `private` |
| Stop a class being extended | `final` |
| Unfinished class with methods children must write | abstract class |
| A promise of methods, many per class | interface |
| Check what class an object is | `instanceof` |
| Make a real copy of an object | `clone` |
| Same call, different result per object | polymorphism |
| Private data + safe methods | encapsulation |
| Are types required in PHP? | No, they're optional, but recommended |

---

## Extra: shortcuts you may see in other code

You don't need these to understand the lessons, but you will meet them online and in Laravel.

**Constructor property promotion (PHP 8.0+).** Declare and set a property in one line:
```php
public function __construct(private string $phone) {}
// is the same as:
private string $phone;
public function __construct(string $phone) { $this->phone = $phone; }
```

**`readonly` (PHP 8.1+).** Anyone can read it, but it can be set only once:
```php
public readonly string $code;
```

**`__toString()`.** PHP calls it when you `echo $object`.

**Asymmetric visibility (PHP 8.4+).** Public to read, private to change:
```php
public private(set) float $balance = 0;
```
Lab computers with older PHP (8.2) will show a syntax error for this one.
