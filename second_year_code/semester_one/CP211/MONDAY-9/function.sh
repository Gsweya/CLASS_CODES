#! /bin/bash

x=5

function salamu() {
    echo "Hello World Function!"
    echo $x
}
salamu


function hello() {
    echo "Good Morning $1 $2!"
    echo "The name fo this script is: " $0
}
hello CIVE udom
