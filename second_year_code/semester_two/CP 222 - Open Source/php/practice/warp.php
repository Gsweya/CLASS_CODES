<?php

    $count = 0;

    while (++$count <= 12)
    {
        echo "$count times 12 is " .$count * 12 . "<br>";
    
    }

    echo "<br>";

    $j = 10;

    while ($j > -10){
        $j--;

        if ($j == 0) continue;

        echo (10 / $j) . "<br>";
    }
        

?>