#! /bin/bash

array=("A" "B" "C" "D" "E")

#Print entire array
echo "${array[@]}"

# access single element
echo "${array[1]}"

# Print a range of elements
echo "${array[@]:1:3}"

# Print from an index to the end
echo "${array[@]:3}"
