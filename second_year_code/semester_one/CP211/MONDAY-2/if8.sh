#! /bin/bash
for num in 1..10, xxxx, yyyy, zzzz
do
    echo $num
done

for num in 1..10 xxxx qqqq rrrr
do
    echo $num
done
