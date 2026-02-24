#! /bin/bash

read -p "Enter username: "  username

if id | grep -q "$username"; then
    id "$username"
else
    echo "User does not exist."
fi
