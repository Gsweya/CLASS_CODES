<?php
 if (PHP_SAPI !== 'cli') header('Content-Type: text/plain');

// =====================================================================
// F. SYSTEM DEMONSTRATION
// Uses: classes, objects, constructors, encapsulation, inheritance,
// method overriding, polymorphism, interfaces, validation and arrays.
// =====================================================================


// ---------- D. Interface ----------
interface Enrollable {

    // Takes a Course object (not just the code), so the student can
    // later show the full course details, not only "CP 311".
    public function enrollCourse(Course $course);
}



// ---------- E. Course class ----------
 class Course {
    private $courseCode;
    private $courseName;
    private $creditHours;


    public function __construct($courseCode, $courseName, $creditHours)
    {
        // Validation: credit hours must be a whole number from 1 to 6.
        // Throwing an exception STOPS the object from being created.
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



// ---------- A. Student class (implements D) ----------
 class Student implements Enrollable {
    private $studentId;
    private $fullName;
    private $email;
    private $programme;
    private $enrolledCourses = [];   // array of Course objects


    public function __construct($studentId,$fullName, $email, $programme) {
        $this->fullName = $fullName;
        $this->email = $email;
        $this->programme = $programme;
        $this->studentId = $studentId;
    }

    // Enrollable function implemented
    #[Override]
    public function enrollCourse(Course $course)
    {
        // Prevent duplicate registration: look for the same course code
        foreach ($this->enrolledCourses as $enrolled) {
            if ($enrolled->get_courseCode() === $course->get_courseCode()) {
                echo $this->fullName . " is already registered for " . $course->get_courseCode() . "\n";
                return;
            }
        }

        // else just add the course to the list of courses we have
        $this->enrolledCourses[] = $course;
        echo $this->fullName . " successfully registered for " . $course->get_courseCode() . "\n";
    }

    public function get_studentId () {
        return $this->studentId;
    }

    public function get_fullName() {
        return $this->fullName;
    }

    public function get_email() {
        return $this->email;
    }

    public function get_programme() {
        return $this->programme;
    }

    // Setters: only the details that are allowed to change
    public function set_email($email) {
        $this->email = $email;
    }

    public function set_programme($programme) {
        $this->programme = $programme;
    }

    public function displayStudentDetails() {
        echo "\n=== STUDENT INFORMATION ===\n";
        echo "Student ID: " . $this->get_studentId();
        echo "\nFull Name: " . $this->get_fullName();
        echo "\nEmail: " . $this->get_email();
        echo "\nProgramme: " . $this->get_programme();
        echo "\n";
    }

    public function getEnrolledCoursesInfo() {
        if (count($this->enrolledCourses) === 0) {
            echo "No courses registered yet.\n";
            return;
        }

        echo "Registered courses: " . count($this->enrolledCourses) . "\n\n";
        foreach ($this->enrolledCourses as $course) {
            $course->displayCourseDetails();
        }
    }
 }



// ---------- B. Inheritance ----------
class UndergraduateStudent extends Student {
    // Part B: year of study is the undergraduate's extra property,
    // so it lives here and not in Student.
    private $yearOfStudy;

    public function __construct($studentId, $fullName, $email, $programme, $yearOfStudy)
    {
        parent::__construct($studentId, $fullName, $email, $programme);
        $this->yearOfStudy = $yearOfStudy;
    }

    public function get_yearOfStudy() {
        return $this->yearOfStudy;
    }

    public function set_yearOfStudy($yearOfStudy) {
        $this->yearOfStudy = $yearOfStudy;
    }

    #[Override]
    public function displayStudentDetails()
    {
        parent::displayStudentDetails();
        echo "Type: Undergraduate\n";
        echo "Year Of Study: " . $this->yearOfStudy . "\n";
    }
}

class PostgraduateStudent extends Student {
    private $researchArea;

    public function __construct($studentId, $fullName, $email, $programme,$researchArea)
    {
        parent::__construct($studentId, $fullName, $email, $programme);
        $this->researchArea = $researchArea;
    }

    public function get_researchArea() {
        return $this->researchArea;
    }

    #[Override]
    public function displayStudentDetails()
    {
        parent::displayStudentDetails();
        echo "Type: Postgraduate\n";
        echo "Research Area: " . $this->researchArea . "\n";
    }
}



// ---------- C. Polymorphism ----------
// One function, any kind of Student. The SAME call gives DIFFERENT
// output depending on the object that is passed in.
function displayStudent(Student $student) {
    $student->displayStudentDetails();
}



// =====================================================================
// DEMONSTRATION
// =====================================================================

// Two Undergraduate Students and one Postgraduate Student
$undergrad_one = new UndergraduateStudent("T24-03-10XXX", "taliko taliko", "taliko@gmail.com", "CS", 3);
$undergrad_two = new UndergraduateStudent("T24-03-10CCC", "adiko adiko", "adiko@gmail.com",  "CSDFE", 2);

$postgrad_one = new PostgraduateStudent("T24-03-10XXXX", "asimane asimane", "asimane@gmail.com", "CS", "Machine Learning");


// Three Courses
$course_one   = new Course("CP 311", "Internet Programming II", 3);
$course_two   = new Course("CP 313", "Mobile Application Development", 3);
$course_three = new Course("CP 315", "Database Systems II", 2);


echo "########## 1. COURSE INFORMATION ##########\n\n";
$course_one->displayCourseDetails();
$course_two->displayCourseDetails();
$course_three->displayCourseDetails();


echo "########## 2. VALIDATION: invalid credit hours ##########\n\n";
try {
    $bad_course = new Course("CP 999", "Bad Course", -3);
} catch (InvalidArgumentException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}


echo "\n########## 3. COURSE REGISTRATION ##########\n\n";
$undergrad_one->enrollCourse($course_one);
$undergrad_one->enrollCourse($course_two);
$undergrad_one->enrollCourse($course_one);     // duplicate: refused

$undergrad_two->enrollCourse($course_two);
$undergrad_two->enrollCourse($course_three);

$postgrad_one->enrollCourse($course_one);
$postgrad_one->enrollCourse($course_three);
$postgrad_one->enrollCourse($course_three);    // duplicate: refused


echo "\n########## 4. POLYMORPHISM: displayStudent() ##########\n";
$students = [$undergrad_one, $undergrad_two, $postgrad_one];

foreach ($students as $student) {
    displayStudent($student);          // same call, different output
    $student->getEnrolledCoursesInfo();
}


echo "\n########## 5. ENCAPSULATION: setters ##########\n";
$undergrad_two->set_yearOfStudy(3);
$undergrad_two->set_email("adiko@udom.ac.tz");
displayStudent($undergrad_two);

?>
