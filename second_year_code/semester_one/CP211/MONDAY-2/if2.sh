#! /bin/bash
if grep -q $1 /etc/passwd; then
    echo "User exists"
else
    echo "User does not exist"
fi
