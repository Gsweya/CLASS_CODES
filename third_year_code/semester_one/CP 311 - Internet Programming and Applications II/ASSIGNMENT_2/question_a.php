<?php

 if (PHP_SAPI !== 'cli') header('Content-Type: text/plain');

 class Student {
    private $studentId;
    private $fullName;
    private $email;
    private $programme;
    private $yearOfStudy;


    public function __construct($studentId,$fullName, $email, $programme, $yearOfStudy) {
        $this->fullName = $fullName;
        $this->email = $email;
        $this->programme = $programme;
        $this->yearOfStudy = $yearOfStudy;
        $this->studentId = $studentId;
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

    // Setters: only the details that are allowed to change.
    // (studentId and fullName stay fixed once the student is created.)
    public function set_email($email) {
        $this->email = $email;
    }

    public function set_programme($programme) {
        $this->programme = $programme;
    }

    public function set_yearOfStudy($yearOfStudy) {
        $this->yearOfStudy = $yearOfStudy;
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



 // Creating actual object
 $student = new Student("T24-03-10XXX", "Galanda Sweya", "sweya.galanda@gmail.com", "CS", 3);
 
 $student->displayStudentDetails();

 // Using the setters to update the student's information
 $student->set_yearOfStudy(4);
 $student->set_email("galanda.sweya@udom.ac.tz");
 $student->displayStudentDetails();


?>