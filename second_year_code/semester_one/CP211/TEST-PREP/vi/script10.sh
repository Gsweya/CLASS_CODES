#! /bin/bash

read -p "Enter number of lines: "  n

if ((n <= 0)); then
    echo "Please enter a positive number"
    exit 1
fi


line=""
for ((i = 0; i <= n; i++)); do
    line+="*"
    echo "$line"

done
