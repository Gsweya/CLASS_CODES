#! /bin/bash
#
for arg in `seq 1 4`
do
    echo file $arg = assignment$arg
    touch assignment$arg
done
