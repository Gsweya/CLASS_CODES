#! /bin/bash

read -r -p "Enter a positive integer: " n

if [[ ! $n =~ ^[0-9]+$ ]] || ((n <= 0)); then 
	echo "Enter a positive integer greater than 0." >&2
	exit 1
fi

line=""

for ((i = 1; i <= n; i++)); do 
	line+="*"
	echo "$line"
done 

echo "Total number of lines printed: $n"

