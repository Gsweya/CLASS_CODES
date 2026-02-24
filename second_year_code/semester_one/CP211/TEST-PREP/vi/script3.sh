#! /bin/bash

read -p "Enter username: " username
read -p "Enter group name: " group_name

if ! getent passwd "$username" >/dev/null; then
    echo "User $username does not exist."
    exit 1
fi

if ! getent group "$group_name" >/dev/null; then
    groupadd "$group_name"
    echo "Group $group_name created."
else
    echo "$group_name already exists."
fi

usermod -aG "$group_name" "$username"
id -nG "$username"
