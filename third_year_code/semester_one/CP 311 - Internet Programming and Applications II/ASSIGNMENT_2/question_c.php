<?php

 class Student {
    private $studentId;
    private $fullName;
    private $email;
    private $programme;



    public function __construct($studentId,$fullName, $email, $programme) {
        $this->fullName = $fullName;
        $this->email = $email;
        $this->programme = $programme;
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

    public function displayStudentDetails() {
        echo "=== STUDENT INFORMATION\n";
        echo "Student ID: " . $this->get_studentId();
        echo "\nFull Name: " . $this->get_fullName();
        echo "\nEmail: " . $this->get_email();
        echo "\nProgramme: " . $this->get_programme();
        echo "\n";
    }
 }

class UndergraduateStudent extends Student {
    // Part B: year of study is the undergraduate's extra property,
    // so it lives here and not in Student.
    private $yearOfStudy;

    public function __construct($studentId, $fullName, $email, $programme, $yearOfStudy)
    {
        parent::__construct($studentId, $fullName, $email, $programme);
        $this->yearOfStudy = $yearOfStudy;

    }

    #[Override]
    public function displayStudentDetails()
    {
        parent::displayStudentDetails();
        echo "Year Of Study: " . $this->yearOfStudy;
        echo "\n";
    }
}

class PostgraduateStudent extends Student {
    private $researchArea;

    public function __construct($studentId, $fullName, $email, $programme,$researchArea)
    {
        parent::__construct($studentId, $fullName, $email, $programme);
        $this->researchArea = $researchArea;
    }

    #[Override]
    public function displayStudentDetails()
    {
        parent::displayStudentDetails();
        echo "Research Area: " . $this->researchArea;
        echo "\n";
    }
}


$undergraduate = new UndergraduateStudent("T24-03-10XXX","Galanda Sweya", "sweya.galanda@gmail.com", "CS", 3);
$postgraduate = new PostgraduateStudent("T24-03-103XX", "Baki Baki Baki", "baki@gmail.com", "CS", "Trees");




/* Shows that we can call and it produce different results depending on the object itself*/

function displayStudent(Student $student) {
    $student->displayStudentDetails();
}



displayStudent($undergraduate);
displayStudent($postgraduate);

?>
