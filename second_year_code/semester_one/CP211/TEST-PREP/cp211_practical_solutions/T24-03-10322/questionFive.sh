#! /bin/bash
set -eou pipefail

read -r -p "Enter filename: " file_name

if [[ ! -f "$file_name" ]]; then
	echo "file does not exist: $file_name" >&2
	exit 1
fi

echo "Total number of lines: $(wc -l < "$file_name")"
echo "Total numbe of words: $(wc -w < "$file_name")"
echo "Lines containing 'Linux' (case sensitive): "

if ! grep -in "Linux" "$file_name"; then
	echo "No matching  lines found."
fi
