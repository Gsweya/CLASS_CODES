<?php


interface Enrollable {

    public function enrollCourse($courseCode);
}



 if (PHP_SAPI !== 'cli') header('Content-Type: text/plain');

 class Student implements Enrollable {
    private $studentId;
    private $fullName;
    private $email;
    private $programme;
    private $yearOfStudy;
    private $enrolledCourses = [];


    public function __construct($studentId,$fullName, $email, $programme, $yearOfStudy) {
        $this->fullName = $fullName;
        $this->email = $email;
        $this->programme = $programme;
        $this->yearOfStudy = $yearOfStudy;
        $this->studentId = $studentId;
    }

    // Enrollable function overriden
    #[Override]
    public function enrollCourse($courseCode)
    {

    if (in_array($courseCode, $this->enrolledCourses)) {
        echo "Already registered for " . $courseCode . "\n";
        return;
    }

    // else just add the courseCode to the list of courses we   have
        $this->enrolledCourses[] = $courseCode;
        echo "Successfully registered for " . $courseCode . "\n";
        
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

    public function get_yearOfStudy() {
        return $this->yearOfStudy;
    }

    public function displayStudentDetails() {
        echo "=== STUDENT INFORMATION\n";
        echo "Student ID: " . $this->get_studentId();
        echo "\nFull Name: " . $this->get_fullName();
        echo "\nEmail: " . $this->get_email();
        echo "\nProgramme: " . $this->get_programme();
        echo "\nYear Of Study: " . $this->get_yearOfStudy();
        echo "\n";
    }
 }



 $student = new Student("T24-03-XXXXX",  "Takitka Takita", "takita@gmail.com", "CS", 3);
 $student->enrollCourse('CP 311');

 // a test to check and see if that works
  $student->enrollCourse('CP 311');




?>