#! /bin/bash

# use of or in Bash Scripts
admin="sweya"
read -p "Enter your username: " username

if [[ "$username" == "$admin" ]] || [[ "$EUID" -eq 0 ]]; then
    echo "Access granted"
else
    echo "Access denied"
fi
# Check on instance when using a for loop to check all users from an array list !
