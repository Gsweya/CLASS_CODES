<?php

    $score = 90;
    $grade = '';

    80 - 100 
    60 -79 
    40 - 59 
    fail is below 

    if ($score >= 80 && $score <= 100) {
        $grade = 'A';
    } else if ($score >= 60 && $score <= 79) {
        $grade = 'B';
    } else if ($score >= 40 && $score <= 59) {
        $grade = 'C';
    } else if ($score >= 0 && $score <= 39) {
        $grade = 'FAIL';
    } else {
        echo "Invalid input";
    }


    echo "Your score: $score";
    echo "<br>";

    echo "=======================";
    echo "Your grade: $grade";

?>