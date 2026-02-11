#! /bin/bash

function func_add() {
    local x=$1
    local y=$2
    result=$(( x + y ))
}
a=3;b=4
echo "a = $a, b= $b"

result="nothing"
echo "Result before passing arguments: " $result

func_add $a $b
echo "result by passing arguments" $result

func_add $1 $2
echo "result by passing command line arguments: " $result
