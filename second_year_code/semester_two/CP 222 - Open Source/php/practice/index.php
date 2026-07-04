<?php
    echo time();
    echo "<br>";

    function longdate($timestamp)
    {
        return date("l F jS Y", $timestamp);
        // date for reformating the date
    }


    echo  date("l F jS Y", time())
    /*
    $count = 30;
    $wow = 60;
    echo "The count is: $count <br> \$wow <br>";
    echo 'The count is $count';

    $number = 12345 * 67890;
    echo "<br>";
    echo "$number <br>";
    echo substr($number, 3, 4);


    // how to define a constant in PHP
    define("name", 10);
    $name_const = name;

    echo "$name_const";

    function longdate($timestamp)
    {
        return date("l F jS Y", $timestamp);
        // date for reformating the date
    }

    echo "<br>";
    echo '<br>';
    echo longdate(time()); // time() for time or the current time
    echo '<br>';
    echo longdate(time() - 17 * 24 * 60 * 60);

    // global variable
    global $is_logged_in;
    */
?>
