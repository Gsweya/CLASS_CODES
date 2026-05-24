#include <stdio.h>
#include <unistd.h>
#include <sys/wait.h>

/* Experiment 2: Fork + Exec ( Run another program) */

/*
  Replace the child process with a new executable file called ls 
  
  Variations we can use execv, execvp (search PATH), or execle (custom environment)
  
  Exec different programs based on conditions.

*/

int main() {
  pid_t pid = fork();
  
  if (pid == 0) {
    // Child becomes 'ls -l'
    execl("/bin/ls", "ls", "-l", (char *)NULL);
    perror("execl failed"); // Only runs of exec fails 
    _exit(1);
  
  } else if (pid > 0) {
    wait(NULL);
    printf("Parent: ls completed.\n");
  }
   return 0;
   
}
