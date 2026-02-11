#!/usr/bin/env bash
set -euo pipefail

# Pretty printer for sections
section() {
  echo
  echo "=============================="
  echo "$1"
  echo "=============================="
}

section "Script: Demo of ls, pwd, tty, cat, who, whoami, mkdir, rmdir, touch, rm, cd"

section "ls: list items in the current directory"
ls

section "ls -la: long list including hidden files"
ls -la

section "pwd: show current working directory"
pwd

section "tty: show the terminal device"
tty

section "cat: create a file, write into it, then display it"
file1="file.txt"
echo "Hello from $(whoami) at $(date)" > "$file1"
cat "$file1"

section "who: show logged-in users"
who

section "whoami: show current user"
whoami

section "mkdir + rmdir: create and remove a directory"
tmp_dir="dummy_folder2"
mkdir "$tmp_dir"
sleep 10
ls | grep dummy_folder2
rmdir "$tmp_dir"

section "touch + rm: create and remove a file"
tmp_file="dummy_file.txt"
touch "$tmp_file"
rm "$tmp_file"

section "mkdir + cd: create a directory, move into it, and show pwd"
work_dir="dummy_folder3"
mkdir -p "$work_dir"
cd "$work_dir"
pwd

section "touch: create another file in the new directory"
touch "file2.txt"
ls -la

echo
echo "Done."
