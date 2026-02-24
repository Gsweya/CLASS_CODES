#! /bin/bash

read -p "Enter username: " username

if ! grep -q "^$username" /etc/passwd; then
    echo "User $username does not exist."
else
    id $username
fi
