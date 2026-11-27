<!DOCTYPE html>
<html>
<head>
    <title>Age Square Calculator</title>
</head>
<body>

    <h2>Age Square Calculator</h2>

    <form method="POST">

        Name:
        <input type="text" name="name">
        <br><br>

        Age:
        <input type="number" name="age">
        <br><br>

        <input type="submit" value="Calculate">

    </form>

    <?php

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $name = $_POST["name"];
        $age = $_POST["age"];

        // $variable = $_METHOD(POST OR GET)["name of input field"]

        if(empty($name) || empty($age)){
            echo "<p>Please fill all fields.</p>";
        }
        else{

            $square = $age * $age;

            echo "<h3>Result</h3>";
            echo "Name: " . $name . "<br>";
            echo "Age: " . $age . "<br>";
            echo "Square of Age: " . $square;

        }
    }

    ?>

</body>
</html>
