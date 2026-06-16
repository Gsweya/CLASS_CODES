#include <stdio.h>
#include <unistd.h>
#include <sys/wait.h>


int main() {

    pid_t pid = fork();

    if (pid == 0) {

        printf("this is a child process. Pid was = %d\n", pid);
    }
    else if (pid < 0) {
        printf("The child fork failed.");
    }
    else {
        printf("this is the parent process id is: %d ! \n", getpid());
    }
  return 0;
}
