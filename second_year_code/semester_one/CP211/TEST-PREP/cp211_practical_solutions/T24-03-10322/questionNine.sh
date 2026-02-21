#! /bin/bash

read -r -p "Enter first integer: " a
read -r -p "Enter second interger: " b

echo "Addition: $((a + b))"
echo "Subtractoin: $((a - b))"
echo "Multiplication: $((a * b))"

if ((b == 0)) ; then 
	echo "Division: undefined (division by zero)"
else 
	echo "Division: $((a / b))"
fi

