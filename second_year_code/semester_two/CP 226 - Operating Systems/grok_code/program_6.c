#include "unistd.h"
#include "stdio.h"




int main() {

    pid_t pid = fork();

    if (pid == 0) {
        // Child becomes a new program
        execlp("ls", "ls", "-l", NULL); /// Replace child with 'ls' command
        // Code here below only runs if exec fails
        perror("exec failed");
    }

    return 0;

}
