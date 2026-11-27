<?php
    $object = new User;
    print_r($object);

    class User 
    {
        public $name, $password;

        function save_user(){

            echo "Save User Code goes here";
        }
    }



    echo "<br>";
    $temp = new User('name', 'password');
    $temp->name = "Joe";
    $temp->password = "mypass";
    print_r($temp); echo "<br>";

    $temp->save_user();

   

?>