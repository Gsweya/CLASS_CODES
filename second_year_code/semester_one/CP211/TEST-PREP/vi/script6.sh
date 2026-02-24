#! /bin/bash

cut -d: -f1 /etc/passwd | sort
cut -d: -f1 /etc/passwd | wc -l

awk -F: '$7=="/bin/bash" {print $1}' /etc/passwd
