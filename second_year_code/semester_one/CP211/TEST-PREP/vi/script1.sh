#! /bin/bash

{
    echo "Current logged-in user: $(whoami)"
    echo "Current working directory: $(pwd)"
    echo "Current date and time: $(date '+%d-%m-%Y %H:%M:%S')"
} > "system_info.txt"

cat system_info.txt

echo "Number of lines in syste_info.txt: $(wc -l < "system_info.txt")"
