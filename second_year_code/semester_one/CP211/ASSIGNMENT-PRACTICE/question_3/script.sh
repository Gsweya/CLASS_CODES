arr=( a b c d)
unset 'arr[2]'

echo "${arr[@]}"
echo "${!arr[@]}"
echo "${arr[2]}"


# Fix indexing
arr=("${arr[@]}")
echo "${!arr[@]}"
