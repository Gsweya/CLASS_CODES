#!/bin/bash

arr=(james david john)

# Print original array
for name in "${arr[@]}"; do
    echo "$name"
done

echo "---- inserting ----"

# Insert "peter" at index 1
idx=1
arr=("${arr[@]:0:$idx}" "peter" "${arr[@]:$idx}")

# Print updated array
for name in "${arr[@]}"; do
    echo "$name"
done
