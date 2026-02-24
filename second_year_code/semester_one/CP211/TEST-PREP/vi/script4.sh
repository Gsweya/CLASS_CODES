#! /bin/bash

file_name="secure.txt"

:> "$file_name"
chmod 740 "$file_name"
ls -l | grep "$file_name"
