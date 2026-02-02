#! /bin/bash

read -p "Enter username: " username

if grep -q $username /etc/passwd; then
    echo "User exists"
else
    echo "User does not exist"
fi
