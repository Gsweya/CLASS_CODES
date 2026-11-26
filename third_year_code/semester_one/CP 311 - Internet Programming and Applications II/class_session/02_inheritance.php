<?php
// =====================================================================
// LESSON 2: INHERITANCE
// Run it:  php 02_inheritance.php
// =====================================================================
//
// A CHILD class can "extends" a PARENT class.
// The child gets everything the parent has, for free.
// Then the child can:
//   1. ADD new things of its own
//   2. OVERRIDE (replace) a parent method with its own version
//
// Ask: "Is a Student a Person?"  Yes -> inheritance fits.

if (PHP_SAPI !== 'cli') header('Content-Type: text/plain');


// ---------------------------------------------------------------------
// The PARENT class
// ---------------------------------------------------------------------
class Person
{
    public string $name;
    public string $email;

    public function __construct(string $name, string $email)
    {
        $this->name = $name;
        $this->email = $email;
    }

    public function describe(): string
    {
        return $this->name . " (" . $this->email . ")";
    }
}


// ---------------------------------------------------------------------
// CHILD 1: Student
// ---------------------------------------------------------------------
class Student extends Person
{
    public string $programme;   // NEW: only students have a programme

    public function __construct(string $name, string $email, string $programme)
    {
        // Ask the parent to set name and email for us.
        // If you forget this line, name and email stay empty!
        parent::__construct($name, $email);

        $this->programme = $programme;
    }

    // NEW method: only students can register
    public function register(string $course): string
    {
        return $this->name . " registered for " . $course;
    }

    // OVERRIDE: same name as the parent's method, new behaviour
    public function describe(): string
    {
        return $this->name . " studies " . $this->programme;
    }
}


// ---------------------------------------------------------------------
// CHILD 2: Lecturer
// ---------------------------------------------------------------------
class Lecturer extends Person
{
    // No constructor here, so PHP uses the parent's constructor.

    // OVERRIDE, but reuse the parent's version with parent::
    public function describe(): string
    {
        return "Dr. " . parent::describe();
    }
}


// ---------------------------------------------------------------------
// Try it
// ---------------------------------------------------------------------
$student  = new Student("Juma", "juma@udom.ac.tz", "Computer Science");
$lecturer = new Lecturer("Mrema", "mrema@udom.ac.tz");
$visitor  = new Person("Neema", "neema@gmail.com");

echo "--- Things the child got for free ---\n";
echo $student->name . "\n";    // $name was written in Person, not in Student
echo $student->email . "\n";

echo "\n--- New method only Student has ---\n";
echo $student->register("CP 311") . "\n";

echo "\n--- Overridden methods ---\n";
echo $visitor->describe() . "\n";    // Person's version
echo $student->describe() . "\n";    // Student's version
echo $lecturer->describe() . "\n";   // Lecturer's version


// ---------------------------------------------------------------------
// POLYMORPHISM: same method call, different result for each object
// ---------------------------------------------------------------------
echo "\n--- One loop, three kinds of people ---\n";

$people = [$visitor, $student, $lecturer];

foreach ($people as $person) {
    echo $person->describe() . "\n";
}


// ---------------------------------------------------------------------
// instanceof: "is this object of that class (or its child)?"
// ---------------------------------------------------------------------
echo "\n--- instanceof ---\n";

if ($student instanceof Person) {
    echo "Juma is a Person\n";       // yes, a Student IS A Person
}
if ($student instanceof Lecturer) {
    echo "Juma is a Lecturer\n";     // no, so this line does not print
}


// ---------------------------------------------------------------------
// Good to know
// ---------------------------------------------------------------------
// - A class can extend only ONE parent:  class A extends B, C   <- error
// - "final" stops inheritance:
//       final class Dean { }            -> nobody can extend Dean
//       final public function x() { }   -> children cannot override x()
