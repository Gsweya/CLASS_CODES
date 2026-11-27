<?php
// =====================================================================
// LESSON 7: EVERYTHING TOGETHER (a small university system)
// Run it:  php 07_all_together.php
// =====================================================================
//
// Look for these labels in the code to find each idea:
//   [OBJECT] [INHERITANCE] [ACCESS] [ENCAPSULATION]
//   [ABSTRACT] [INTERFACE] [POLYMORPHISM]
//
//   Payable (interface)          Member (abstract class)
//         ^                          ^            ^
//         |                          |            |
//         +-------- Student ---------+         Lecturer

if (PHP_SAPI !== 'cli') header('Content-Type: text/plain');


// [INTERFACE] anyone who must pay fees promises to have getFees()
interface Payable
{
    public function getFees(): float;
}


// [ABSTRACT] every member has a name, but each type has its own role
abstract class Member
{
    protected string $name;        // [ACCESS] protected: children can use it

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    abstract public function role(): string;   // each child MUST write this

    public function badge(): string
    {
        return $this->role() . ": " . $this->name;
    }
}


// [INHERITANCE] Student extends Member, and [INTERFACE] implements Payable
class Student extends Member implements Payable
{
    private array $courses = [];   // [ENCAPSULATION] private list, changed only by addCourse()

    public function role(): string
    {
        return "Student";
    }

    // [ENCAPSULATION] the method checks the rule: at most 3 courses
    public function addCourse(string $course): void
    {
        if (count($this->courses) >= 3) {
            echo "Refused: " . $this->name . " already has 3 courses\n";
            return;
        }
        $this->courses[] = $course;
        echo $this->name . " added " . $course . "\n";
    }

    public function getFees(): float
    {
        return count($this->courses) * 150000;   // 150,000 TZS per course
    }
}


class Lecturer extends Member
{
    public function role(): string
    {
        return "Lecturer";

    }
}


// ---------------------------------------------------------------------
// [OBJECT] create the people
// ---------------------------------------------------------------------
$juma  = new Student("Juma");
$asha  = new Student("Asha");
$mrema = new Lecturer("Mrema");

echo "--- Registering courses ---\n";
$juma->addCourse("CP 311");
$juma->addCourse("CP 312");
$juma->addCourse("CP 313");
$juma->addCourse("CP 314");   // refused: 4th course
$asha->addCourse("CP 311");


echo "\n--- Badges [POLYMORPHISM] ---\n";
$members = [$juma, $asha, $mrema];

foreach ($members as $member) {
    echo $member->badge() . "\n";   // same call, each class answers with its own role()
}


echo "\n--- Fees [INTERFACE] ---\n";
foreach ($members as $member) {
    if ($member instanceof Payable) {
        echo $member->getName() . " pays " . $member->getFees() . " TZS\n";
    } else {
        echo $member->getName() . " does not pay fees\n";
    }
}


// ---------------------------------------------------------------------
// EXERCISE: add a "Staff" class that extends Member and implements
// Payable (staff pay a 20000 TZS parking fee). Add a staff member to
// $members. The loops above should work WITHOUT any changes.
// ---------------------------------------------------------------------
