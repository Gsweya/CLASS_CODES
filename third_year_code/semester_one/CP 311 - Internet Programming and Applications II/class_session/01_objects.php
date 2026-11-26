<?php
// =====================================================================
// LESSON 1: CLASSES AND OBJECTS
// Run it:  php 01_objects.php
// =====================================================================
//
// A CLASS is a blueprint (a plan).
// An OBJECT is a real thing made from that plan.
//
//   Class:   Student
//   Objects: Juma, Asha   (two students made from the same plan)

// This line only makes the browser keep the line breaks. You can ignore it.
if (PHP_SAPI !== 'cli') header('Content-Type: text/plain');


// ---------------------------------------------------------------------
// STEP 1: Write the class (the blueprint)
// ---------------------------------------------------------------------
class Student
{
    // PROPERTIES: the information every student has
    public string $name;
    public int $year;

    // CONSTRUCTOR: runs by itself when we create a student with "new"
    public function __construct(string $name, int $year)
    {
        // $this means "this student", the one being created right now
        $this->name = $name;
        $this->year = $year;
    }

    // METHOD: something a student can do
    public function introduce(): string
    {
        return "Hi, I am " . $this->name . " and I am in year " . $this->year;
    }

    // Another method: it changes the student's own data
    public function promote(): void
    {
        $this->year = $this->year + 1;
    }
}


// ---------------------------------------------------------------------
// STEP 2: Create objects with "new"
// ---------------------------------------------------------------------
$juma = new Student("Juma", 3);
$asha = new Student("Asha", 1);

echo "--- Two objects from one class ---\n";
echo $juma->introduce() . "\n";
echo $asha->introduce() . "\n";


// ---------------------------------------------------------------------
// STEP 3: Use properties and methods with the arrow ->
// ---------------------------------------------------------------------
echo "\n--- Each object has its own data ---\n";

$asha->promote();                 // only Asha moves up a year

echo "Asha is now in year " . $asha->year . "\n";   // 2
echo "Juma is still in year " . $juma->year . "\n"; // 3 (unchanged)

$juma->name = "Juma Mwakalinga";  // we can change a public property directly
echo "New name: " . $juma->name . "\n";


// ---------------------------------------------------------------------
// STEP 4: Constants and static properties belong to the CLASS
// ---------------------------------------------------------------------
// Normal properties: each object has its own copy.
// A constant or static property: ONE value, shared by the whole class.
// We reach them with  ClassName::  instead of  ->

class School
{
    const NAME = "UDOM";             // constant: can never change
    public static int $visitors = 0; // static: shared, can change

    public static function addVisitor(): void
    {
        self::$visitors = self::$visitors + 1;   // self:: means "this class"
    }
}

echo "\n--- Constants and static ---\n";
School::addVisitor();
School::addVisitor();
echo "School: " . School::NAME . "\n";
echo "Visitors: " . School::$visitors . "\n";    // 2


// ---------------------------------------------------------------------
// STEP 5: Copying an object needs "clone"
// ---------------------------------------------------------------------
echo "\n--- = does not copy, clone does ---\n";

$sameStudent = $asha;           // NOT a copy: both names point to the same Asha
$sameStudent->name = "Asha S.";
echo "Asha's name is now: " . $asha->name . "\n";   // changed too!

$copy = clone $asha;            // a real, separate copy
$copy->name = "Someone else";
echo "Asha's name is still: " . $asha->name . "\n"; // not changed
