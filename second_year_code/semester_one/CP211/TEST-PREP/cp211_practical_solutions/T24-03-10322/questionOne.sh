#! /bin/bash

set -eou pipefail 

output_file="system_info.txt"

{
	echo "Current logged-in user: $USER"
	echo "Current working directory: $PWD"
	echo "Current date and time: $(date '+%d-%m-%Y %H:%M:%S')"
} > "$output_file"

echo "Information saved to $output_file"
echo "Number of lines in $output_file: $(wc -l < "$output_file")"

