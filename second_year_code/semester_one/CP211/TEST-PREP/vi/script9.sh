#! /bin/bash

echo "Enter two numbers: "
read -p "Enter first number: " a
read -p "Enter second number: " b


echo "Addition: $((a + b))"
echo "Subtraction: $((a + b))"
echo "Multiplication: $((a + b))"

if ((b == 0)); then
    echo "Division error: Incomputable expression."
    exit 1
else
    echo "Division: $((a / b))"
fi
