#! /bin/bash
#
num=1
while [[ $Num -lt 10 ]]
do
    while [[ $Num -lt 3 ]]
    do
        if [[ $num -eq 7 ]]
        then
            echo $num
            break

        fi
        echo $num
        ((num++))
done
    echo $num
    ((num++))
done
echo "Loop completed"
