#include <stdio.h>
#include <unistd.h>
#include <sys/wait.h>


int main() {

  pid_t pid = fork();
  
  if (pid < 0) {
    perror("fork failed");
    return 1;
    
  } else if (pid == 0) {
    // Child 
    printf("Child: PID=%d, Parent PID=%d\n", getpid(), getppid());
    sleep(2); // Simulate work 
    return 42; // Exit with a status
  } else {
    // Parent 
    printf("Parent: PID=%d, Child PID=%d\n", getpid(), pid);
    int status;
    wait(&status); // Wait for child 
    printf("Child exited with status %d\n", WEXITSTATUS(status));
    
  }
  return 0;
}
