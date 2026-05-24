#include <stdio.h>
#include <unistd.h>
#include <sys/wait.h>


void child_task() {
  printf("Child process (PID=%d) is doing its task...\n", getpid());
  // Put any child-specific code here
  sleep(2);
  printf("Child finished its work.\n");

}

void parent_task(pid_t child_pid) {
  printf("Parent process (PID=%d) is doing its task...\n", getpid());
  wait(NULL);
  printf("Parent: Child finished.\n");

}

int main() {
  pid_t pid = fork();
  
  if (pid == 0) {
  // == CHILD ===
  child_task(); // call child function
  return 0;     // Child should exit 
  }
  else if (pid > 0) {
    // == PARENT ===
    parent_task(pid);       // Call parent function
  }
    else {
        perror("fork failed");
    }
    
    return 0;
    
  }
