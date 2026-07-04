<?php

    /*
    for ($i = 2; $i <= 100; $i+=2){
        echo "$i <br>";
    }
    */

    // prompt user to enter marks...
    $marks = array();
    $total = 0;


    for($i = 1; $i <= 5; $i++){

        $marks[$i] = readline("Enter score $i: ");
        
        if ($marks[$i] < 0 || $marks > 100){
            echo "Invalid Input";
        }

        $total += $marks[$i];
    }

    $average = $total / 5;
    $grade = '';

    switch($average){

        case ($average >= 80 && $average <= 100):
            $grade = 'A';
            break;
        
        case ($average >= 70):
            $grade = 'B';
            break;
        
        case ($average >= 60):
            $grade = 'C';
            break;
        
        case ($average >= 50):
            $grade = 'D';
            break;
        
        case ($average >= 0):
            $grade = 'F';
            break;

        default:
            echo "Invalid input";   

    }

    echo "<br>Your grade is: $grade";
?>