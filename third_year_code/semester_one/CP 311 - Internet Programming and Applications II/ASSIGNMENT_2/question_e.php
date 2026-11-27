<?php

 if (PHP_SAPI !== 'cli') header('Content-Type: text/plain');


class Course {
    private $courseCode;
    private $courseName;
    private $creditHours;


    public function __construct($courseCode, $courseName, $creditHours)
    {
        // Validation: credit hours must be a whole number from 1 to 6.
        // Throwing an exception STOPS the object from being created,
        // so an invalid course can never exist.
        if (!is_int($creditHours) || $creditHours < 1 || $creditHours > 6) {
            throw new InvalidArgumentException("Invalid credit hours (" . $creditHours . ") for " . $courseCode . ": must be a whole number from 1 to 6.");
        }

        $this->courseCode = $courseCode;
        $this->courseName = $courseName;
        $this->creditHours = $creditHours;
    }

    public function get_courseCode(){
        return $this->courseCode;
    }

    public function get_courseName() {
        return $this->courseName;
    }

    public function get_creditHours() {
        return $this->creditHours;
    }

    public function displayCourseDetails() {
        echo "==== COURSE INFORMATION ====\n";
        echo "Course Code: " . $this->get_courseCode() . "\n";
        echo "Course Name: " . $this->get_courseName() . "\n";
        echo "Credit Hours: " . $this->get_creditHours() . "\n";
        echo "\n";
    }
}

// Test: a valid course
$course_test_one = new Course("CP 311", "Internet Programming II", 3);
$course_test_one->displayCourseDetails();

// Test: invalid credit hours are rejected
$bad_values = [-3, 0, 3.4, "abc", 99];

foreach ($bad_values as $value) {
    try {
        $course_test_two = new Course("CP 999", "Bad Course", $value);
        $course_test_two->displayCourseDetails();
    } catch (InvalidArgumentException $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
}

?>
