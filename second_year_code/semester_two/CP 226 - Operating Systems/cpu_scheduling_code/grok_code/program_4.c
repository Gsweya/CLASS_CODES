/* Experiment 4: Playing Audion in a Subprocess (Fork + Exec) */

/*
  Use a system audio player like aplay (for WAV on Linux)
*/

#include <stdio.h>
#include <unistd.h>
#include <sys/wait.h>
#include <stdlib.h>

int play_audio(const char *filename) {
  pid_t pid = fork();

  if (pid == 0) {
    // Child: play audio (non-blocking for parent)
    execlp("aplay", "aplay", filename, (char *)NULL); // or "paplay" , "afplay"
    perror("exec failed");
    _exit(1);
  } else if (pid > 0) {
    return pid; // Return child PID to parent
  }

  return -1;
}

int main() {
  pid_t audio_pid = play_audio("sound.wav");
  if (audio_pid > 0) {
    printf("Audio playing in background, PID %d\n", audio_pid);

    // Do other work....

    printf("Printing numbe of seconds: ");
    for (int i = 0; i <= 10; i++){
        printf("Second: %d\n", i);

    }

    sleep(10);

    /*    // Optionally stop it
    kill(audio_pid, SIGTERM);
    waitpid(audio_pid, NULL, 0);
    */
  }

  return 0;

}
