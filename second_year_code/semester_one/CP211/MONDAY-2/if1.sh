#! /bin/bash

read -p "Please entre your greetings: " greetings

if (($greetings == "hello" )); then
    echo Hello
else
    echo greeting is wrong;
fi
