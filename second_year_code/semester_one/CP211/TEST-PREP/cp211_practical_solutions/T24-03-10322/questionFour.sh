#! /bin/bash 

set -eou pipefail 

file_name="secure.txt"

: > "$file_name"
chmod 740 "$file_name"
ls -l "$file_name"

