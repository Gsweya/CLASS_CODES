<?php
// =====================================================================
// LESSON 6: INTERFACES
// Run it:  php 06_interfaces.php
// =====================================================================
//
// An INTERFACE is a promise (a contract).
// It only lists method NAMES. It has no code inside them.
// A class that "implements" the interface PROMISES to write those methods.
//
// Example: a shop can accept many ways to pay: mobile money, card, cash.
// They are very different things, but they can all pay().
// So we make an interface called PaymentMethod with one rule: "have pay()".

if (PHP_SAPI !== 'cli') header('Content-Type: text/plain');


// ---------------------------------------------------------------------
// The interfaces (the promises)
// ---------------------------------------------------------------------
interface PaymentMethod
{
    public function pay(float $amount): string;   // no body, just the name
}

interface Refundable
{
    public function refund(float $amount): string;
}


// ---------------------------------------------------------------------
// Classes that keep the promise
// ---------------------------------------------------------------------
class MobileMoney implements PaymentMethod, Refundable   // a class can implement MANY interfaces
{
    public function pay(float $amount): string
    {
        return "Paid " . $amount . " TZS by mobile money";
    }

    public function refund(float $amount): string
    {
        return "Sent " . $amount . " TZS back to the phone";
    }
}

class Card implements PaymentMethod
{
    public function pay(float $amount): string
    {
        return "Paid " . $amount . " TZS by card";
    }
}

class Cash implements PaymentMethod
{
    public function pay(float $amount): string
    {
        return "Paid " . $amount . " TZS in cash";
    }
}


// ---------------------------------------------------------------------
// The shop only cares that the object CAN pay.
// "PaymentMethod $method" means: give me ANY object that implements PaymentMethod.
// ---------------------------------------------------------------------
function checkout(PaymentMethod $method, float $amount): void
{
    echo $method->pay($amount) . "\n";
}


echo "--- One checkout, three different classes ---\n";
checkout(new MobileMoney(), 25000);
checkout(new Card(), 40000);
checkout(new Cash(), 5000);

echo "\n--- MobileMoney also kept the Refundable promise ---\n";
$mobile = new MobileMoney();
echo $mobile->refund(2000) . "\n";

echo "\n--- You cannot create an interface directly ---\n";
try {
    $p = new PaymentMethod();
} catch (Error $e) {
    echo "Error: " . $e->getMessage() . "\n";
}


// ---------------------------------------------------------------------
// Good to know
// ---------------------------------------------------------------------
// - Want to add bank transfer later? Write a new class that implements
//   PaymentMethod. The checkout() function does not change at all.
// - A class can extend ONE class but implement MANY interfaces:
//       class Student extends Person implements Payable, Printable { }
// - If a class forgets a method it promised, PHP gives a Fatal error.
