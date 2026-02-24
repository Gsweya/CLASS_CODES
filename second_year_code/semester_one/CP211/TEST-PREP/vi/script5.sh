#! /bin/bash

read -p "Enter the filename: " file_name

if [[ ! -f "$file_name" ]]; then
 echo "$file_name does not exist"
 exit 1
fi

echo -n "Total number of lines in the file: $(wc -l < "$file_name")"
echo
echo -n "Total number of words in the file: $(wc -w < "$file_name")"
echo

echo "All lines with the word 'Linux' case insensitive:"

if ! grep -in "Linux" "$file_name"; then
    echo "No line case of Linux found." 2>/dev/null
fi
