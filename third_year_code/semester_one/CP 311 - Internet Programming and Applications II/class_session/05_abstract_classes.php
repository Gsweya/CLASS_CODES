<?php
// =====================================================================
// LESSON 5: ABSTRACT CLASSES
// Run it:  php 05_abstract_classes.php
// =====================================================================
//
// An ABSTRACT class is an unfinished parent class.
//   - You can NOT create an object from it:  new Shape()  -> error
//   - It can have normal, finished methods (shared by all children)
//   - It can have ABSTRACT methods: just a name, no body { }.
//     Every child MUST write the body for these.
//
// Example: every shape has an area, but each shape calculates it
//          differently. So Shape says "you must have area()",
//          and each child writes its own formula.

if (PHP_SAPI !== 'cli') header('Content-Type: text/plain');


abstract class Shape
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    // ABSTRACT method: no body, ends with ;
    // "Every child must write its own area()"
    abstract public function area(): float;

    // NORMAL method: already finished, every child gets it for free
    public function describe(): string
    {
        return $this->name . " has area " . round($this->area(), 2);
    }
}


class Rectangle extends Shape
{
    private float $width;
    private float $height;

    public function __construct(float $width, float $height)
    {
        parent::__construct("Rectangle");
        $this->width = $width;
        $this->height = $height;
    }

    // MUST write this, because Shape said so
    public function area(): float
    {
        return $this->width * $this->height;
    }
}


class Circle extends Shape
{
    private float $radius;

    public function __construct(float $radius)
    {
        parent::__construct("Circle");
        $this->radius = $radius;
    }

    public function area(): float
    {
        return 3.14159 * $this->radius * $this->radius;
    }
}


// ---------------------------------------------------------------------
// Try it
// ---------------------------------------------------------------------
echo "--- Each child has its own area() ---\n";

$rectangle = new Rectangle(4, 5);
$circle = new Circle(3);

echo $rectangle->describe() . "\n";   // describe() comes from Shape
echo $circle->describe() . "\n";      // but area() comes from each child


echo "\n--- You cannot create a Shape directly ---\n";
try {
    $shape = new Shape("Mystery");
} catch (Error $e) {
    echo "Error: " . $e->getMessage() . "\n";
}


// ---------------------------------------------------------------------
// Good to know
// ---------------------------------------------------------------------
// If a child FORGETS to write area(), PHP refuses to run the file:
//
//   class Square extends Shape { }
//
//   Fatal error: Class Square contains 1 abstract method and must
//   therefore be declared abstract or implement the remaining methods
