#include <stdio.h>

struct Process {
    int pid;
    int arrivalTime;
    int burstTime;
    int completionTime;
    int turnaroundTime;
    int waitingTime;
};

int main() {
    int n;
    printf("Enter number of processes: ");
    scanf("%d",  %n);

    struct Process p[n];


    for (int i = 0; i < n; i++) {
        p[i].pid = i + 1;

        printf("Process %d - Arrival Time: ", i+1);
        scanf("%d", &p[i].arrivalTime);

        printf("Process %d - Burst Time: ", i+1);
        scanf("%d", &p[i].burstTime);
    }

    // Sort by arrival time (FCFS is non-premptive





    for (int i = 0; i < n; i++) {
        if(currentTime < p[i].arrivalTime)
            currentTime = p[i].completionTime;
    }
}
