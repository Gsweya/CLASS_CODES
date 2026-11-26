<?php
// =====================================================================
// LESSON 3: ACCESS MODIFIERS
// Run it:  php 03_access_modifiers.php
// =====================================================================
//
// Access modifiers decide WHO can use a property or method.
//
//   public     -> everyone
//   protected  -> this class and its CHILD classes (lesson 2)
//   private    -> this class ONLY
//
//                  inside the class | child class | outside code
//   public               yes        |     yes     |     yes
//   protected            yes        |     yes     |     no
//   private              yes        |     no      |     no

if (PHP_SAPI !== 'cli') header('Content-Type: text/plain');


class Employee
{
    public string $name;       // anyone can see it
    protected float $salary;   // Employee + children (like Manager)
    private string $pin;       // Employee only

    public function __construct(string $name, float $salary, string $pin)
    {
        $this->name = $name;
        $this->salary = $salary;
        $this->pin = $pin;
    }

    // Inside the class we can use ALL of them, even private
    public function showInfo(): string
    {
        return $this->name . " earns " . $this->salary . " and has PIN " . $this->pin;
    }
}


class Manager extends Employee
{
    public function bonus(): float
    {
        // protected $salary: the child IS allowed to use it
        return $this->salary * 0.10;

        // private $pin: the child is NOT allowed.
        // Writing $this->pin here would not see the parent's PIN.
    }
}


$worker  = new Employee("Neema", 1200000, "4821");
$manager = new Manager("Baraka", 2500000, "9930");


echo "--- Allowed ---\n";
echo $worker->name . "\n";             // public: OK from outside
echo $worker->showInfo() . "\n";       // public method that uses private data inside
echo "Manager bonus: " . $manager->bonus() . "\n";


echo "\n--- Not allowed ---\n";
// try / catch lets us SEE the error without stopping the whole program.

try {
    echo $worker->salary;              // protected: outside code cannot read it
} catch (Error $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

try {
    echo $worker->pin;                 // private: outside code cannot read it
} catch (Error $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

try {
    $worker->pin = "0000";             // and cannot change it either
} catch (Error $e) {
    echo "Error: " . $e->getMessage() . "\n";
}


// ---------------------------------------------------------------------
// Good to know
// ---------------------------------------------------------------------
// - Methods can have modifiers too:  private function helper() { ... }
// - A method with NO modifier is public.
// - Simple rule: make properties private unless you have a reason not to.
//   Lesson 4 (encapsulation) shows why.
