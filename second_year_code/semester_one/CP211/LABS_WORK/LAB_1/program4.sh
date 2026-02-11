#!/usr/bin/env bash
set -euo pipefail

read -p "Enter number: " input

check_prime() {
    local num=$1

    if (( num <= 1 )); then
        echo "$num -> Not Prime"
        return
    fi

    # Only check up to sqrt(num)
    for (( i=2; i*i<=num; i++ )); do
        if (( num % i == 0 )); then
            echo "$num -> Not Prime"
            return
        fi
    done

    echo "$num -> Prime"
}

check_prime "$input"
check_prime 2
check_prime 5
check_prime 10
check_prime $1
