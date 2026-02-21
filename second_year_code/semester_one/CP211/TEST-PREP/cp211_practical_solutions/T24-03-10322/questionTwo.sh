#! /bin/bash 
set -eou pipefail 

read -r -p "Enter username: " username

if awk -F: -v user="$username" '$1 == user {found=1; exit} END {exit !found}' /etc/passwd; then
	id "$username"
else 
	echo "user does not exist"
fi

