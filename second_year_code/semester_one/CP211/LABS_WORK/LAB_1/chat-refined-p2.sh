#!/usr/bin/env bash
set -euo pipefail

section() {
  echo
  echo "=============================="
  echo "$1"
  echo "=============================="
}

section "Demo: cat, append, concatenate, mv, cp, man, date"

# Setup
mkdir -p dummy_folder1 dummy_folder3
echo "Linux Line 1" > file.txt
echo "File2 content" > file2.txt

section "cat: display file content"
cat file.txt

section "cat (append): append new line to file"
echo "Linux Line 2" >> file.txt
cat file.txt

section "cat (concatenate): merge two files into one"
cat file.txt file2.txt > combined.txt
cat combined.txt

section "mv: move file.txt to dummy_folder1"
mv file.txt dummy_folder1/
ls dummy_folder1

section "cp: copy file2.txt to dummy_folder3"
cp file2.txt dummy_folder3/
ls dummy_folder3

section "man: show manual entry for date (first 10 lines only)"
man date | head -n 10

section "date: display current date and time"
date

echo
echo "Done."
