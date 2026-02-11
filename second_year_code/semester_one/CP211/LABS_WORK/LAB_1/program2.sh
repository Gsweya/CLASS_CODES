echo "Use of the commands cat, cat(append) cat(concatenate), mv, cp, man, date"

echo $(cat file.txt)

echo $(cat file.txt > "Linux Line 2!")
echo $(mv ./file.txt ./dummy_folder1/file.txt)

echo $(cp ./file2.txt ./dummy_folder3/file2.txt)
echo $(ls ./dummy_folder3)

echo $(man)
echo $(date)
