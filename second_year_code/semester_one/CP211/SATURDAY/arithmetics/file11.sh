#! /bin/bash

if (( $EUID != 0)); then
    echo "$USER is not a root user"
