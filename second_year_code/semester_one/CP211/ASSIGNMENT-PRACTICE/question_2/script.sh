old=(a b c d e f)
new=("${old[@]}")

# Show elements between index 1 and 3 (b c d)

for name in ${new[@]:1:3}
do
    echo $name
done
