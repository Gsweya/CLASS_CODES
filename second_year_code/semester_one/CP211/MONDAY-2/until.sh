#! /bin/bash
read counter
until [[ $counter -le 0 ]]
do
    echo $counter
    ((counter--))
done
