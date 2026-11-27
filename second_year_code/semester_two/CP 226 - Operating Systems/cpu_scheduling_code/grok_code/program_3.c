#include <stdio.h>
#include <unistd.h>
#include <sys/wait.h>

/* Experiment 3: Multiple Children, Limiting and Cleanup */

/*
  Create a fixed number of childern (e.g, a pool) and respwan when onw dies. 
  
  Use a loop with fork(), track PIDs in an array, and waitpid() with WHOHANG for non-blocking checks.
  
  Killing processes:
  kill(child_pid, SIGTERM); //Graceful
  kill(child_pid, SIGKILL); // Force (avoid if possible)

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
