#! /bin/bash
echo "Script one to demonstrate the use of the commands ls, pwd , tty, cat, who , whoami, rm , mkdir rmdir , touch and cd"

echo "Starting with ls - Lists items in the directory"
echo $(ls)


echo "Can also be further written with a flag to show hidden files -a or long list -la"
echo $(ls -la)


echo "Moving to the use of pwd, shows the current workign directory"
echo $(pwd)

echo "Demonstration of tty - shows "
echo $(tty)

echo "Reading file content with cat"
echo $(touch file.txt)
echo $(cat file.txt)


echo "Cheking who "
echo $(who)

echo "Running whoami"
echo $(whoami)

echo $(mkdir dummy_folder2)
echo "Removing a directory"
echo $(rmdir dummy_folder2)

echo $(touch dummy_file.txt)
echo "Removing a file"
echo $(rm dummy_file.txt)

echo "Making a directory"
echo $(mkdir dummy_folder3)

echo "Creating a file"
echo $(touch file2.txt)

echo "Changing directory"
echo $(cd dummy_folder3)
