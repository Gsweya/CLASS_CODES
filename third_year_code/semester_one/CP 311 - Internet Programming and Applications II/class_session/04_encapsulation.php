<?php
// =====================================================================
// LESSON 4: ENCAPSULATION
// Run it:  php 04_encapsulation.php
// =====================================================================
//
// Encapsulation means:
//   1. Make the data PRIVATE (nobody outside can touch it directly)
//   2. Give PUBLIC methods that change it safely, checking the rules first
//
// Think of an ATM: you can't open the machine and take money.
// You must use the buttons, and the machine checks your balance first.

if (PHP_SAPI !== 'cli') header('Content-Type: text/plain');


// ---------------------------------------------------------------------
// BAD: no encapsulation (public data)
// ---------------------------------------------------------------------
class OpenAccount
{
    public float $balance = 0;
}

$bad = new OpenAccount();
$bad->balance = -50000;    // nothing stops this. Negative money?!

echo "--- Without encapsulation ---\n";
echo "Balance: " . $bad->balance . "   <- wrong, but nothing stopped it\n";


// ---------------------------------------------------------------------
// GOOD: encapsulation (private data + safe methods)
// ---------------------------------------------------------------------
class BankAccount
{
    private string $owner;
    private float $balance = 0;   // private: only this class can change it

    public function __construct(string $owner)
    {
        $this->owner = $owner;
    }

    // GETTER: lets others READ the balance (but not change it)
    public function getBalance(): float
    {
        return $this->balance;
    }

    public function getOwner(): string
    {
        return $this->owner;
    }

    // Safe way to ADD money: checks the rule first
    public function deposit(float $amount): void
    {
        if ($amount <= 0) {
            echo "Refused: deposit must be more than 0\n";
            return;
        }
        $this->balance = $this->balance + $amount;
        echo "Deposited " . $amount . "\n";
    }

    // Safe way to TAKE money: checks two rules first
    public function withdraw(float $amount): void
    {
        if ($amount <= 0) {
            echo "Refused: withdrawal must be more than 0\n";
            return;
        }
        if ($amount > $this->balance) {
            echo "Refused: not enough money (balance is " . $this->balance . ")\n";
            return;
        }
        $this->balance = $this->balance - $amount;
        echo "Withdrew " . $amount . "\n";
    }
}


echo "\n--- With encapsulation ---\n";
$account = new BankAccount("Asha");

$account->deposit(10000);     // OK
$account->withdraw(3000);     // OK
$account->withdraw(999999);   // refused: not enough money
$account->deposit(-500);      // refused: negative amount

echo "Final balance of " . $account->getOwner() . ": " . $account->getBalance() . "\n";


echo "\n--- Trying to cheat ---\n";
try {
    $account->balance = 1000000;   // private: PHP stops this
} catch (Error $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
echo "Balance is still: " . $account->getBalance() . "\n";


// ---------------------------------------------------------------------
// Good to know
// ---------------------------------------------------------------------
// - There is no setBalance() on purpose. Money should only change
//   through deposit() and withdraw(), because they check the rules.
// - Access modifiers (lesson 3) are the TOOL.
//   Encapsulation is the IDEA of using that tool to protect your data.
