#! /bin/bash

mkdir -p backup

cp *.txt backup/ 2>/dev/null

tar -cvf backup.tar backup
