#!/usr/bin/env bash
set -euo pipefail

section() {
  echo
  echo "=============================="
  echo "$1"
  echo "=============================="
}

section "Demo: chmod, grep, tput (clear, highlight), expr"

# Setup
echo "Linux is powerful" > demo.txt
echo "Linux scripting is fun" >> demo.txt
echo "Bash is everywhere" >> demo.txt

section "tput clear: clear the screen"
sleep 1
tput clear

section "tput highlight (bold text)"
tput bold
echo "This text is highlighted using tput bold"
tput sgr0   # Reset formatting

section "grep: search for the word 'Linux'"
grep "Linux" demo.txt

section "grep with line numbers"
grep -n "Linux" demo.txt

section "expr: simple arithmetic"
a=10
b=5
result=$(expr $a + $b)
echo "$a + $b = $result"

section "chmod: change file permissions"

echo "Current permissions:"
ls -l demo.txt

chmod 755 demo.txt

echo "After chmod 755:"
ls -l demo.txt
