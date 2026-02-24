#! /bin/bash

echo  "Unique logged in users: "
who | awk '{print $1}' | sort -u

echo -n "Number of logged-in users: "
who | awk '{print $1}' | sort -u | wc -l
