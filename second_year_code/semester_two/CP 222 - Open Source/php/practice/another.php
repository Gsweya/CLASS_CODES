<?php
    // test2.php

    
    echo "a: [" . TRUE . "]<br>";
    echo "b: [" . FALSE . "]<br>";

    echo "a:[" . (20 > 9) . "]<br>";
    echo "b:[" . (5 == 6) . "]<br>";
    echo '<br>';
    echo "c:[" . (1 == 0) . "]<br>";

    /*
    $bank_balance = 1000;

    if ($bank_balance > 100) {
        $money  = 100;
        $bank_balance -= $money;

        echo "New Balance: $bank_balance";
    } else {
        echo "Get more money!";
    }
    */


    switch($page){
        case "Home":
            echo "You are selected Home";
            break;
        
        case "About":
            echo "You selected About";
            break;
        
        case "Login":
            echo "You selected Login";
            break;
        
        case "Links":
            echo "You have selected Links";
            break;

        default:
            echo "@$$";
            break;


            echo $fuel <= 1 ? "Fill tank now" : "There's enough fuel";
    }

?>