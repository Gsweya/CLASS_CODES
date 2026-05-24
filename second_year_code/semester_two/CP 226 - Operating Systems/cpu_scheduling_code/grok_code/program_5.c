#include <stdio.h>
#include <unistd.h>

int main() {
  int i = 0;
  
  while (1) {
    pid_t pid = fork();
    
    if (pid < 0) {
      perror("fork failed");  // This will print the reason
      printf("failed after creating %d children\n", i);
      break;
    } else if (pid == 0) {
      sleep(10);
      return 0;
      
    }
    i++;
    if (i % 100 == 0) printf("Created %d children\n", i);
    
    }
    
    return 0;
    
}
    
