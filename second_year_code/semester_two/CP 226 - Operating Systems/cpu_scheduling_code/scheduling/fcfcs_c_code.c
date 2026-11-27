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
    scanf("%d", &n);

    struct Process p[n];

    for(int i = 0; i < n; i++) {
        p[i].pid = i + 1;
        printf("Process %d - Arrival Time: ", i+1);
        scanf("%d", &p[i].arrivalTime);
        printf("Process %d - Burst Time: ", i+1);
        scanf("%d", &p[i].burstTime);
    }

    // Sort by arrival time (FCFS is non-preemptive)
    for(int i = 0; i < n-1; i++) {
        for(int j = 0; j < n-i-1; j++) {
            if(p[j].arrivalTime > p[j+1].arrivalTime) {
                struct Process temp = p[j];
                p[j] = p[j+1];
                p[j+1] = temp;
            }
        }
    }

    int currentTime = 0;
    printf("\nGantt Chart:\n");

    for(int i = 0; i < n; i++) {
        if(currentTime < p[i].arrivalTime)
            currentTime = p[i].arrivalTime;

        printf("| P%d ", p[i].pid);

        p[i].completionTime = currentTime + p[i].burstTime;
        p[i].turnaroundTime = p[i].completionTime - p[i].arrivalTime;
        p[i].waitingTime = p[i].turnaroundTime - p[i].burstTime;

        currentTime = p[i].completionTime;
    }
    printf("|\n");

    float avgWT = 0, avgTAT = 0;
    printf("\nPID\tArrival\tBurst\tCompletion\tTAT\tWaiting\n");
    for(int i = 0; i < n; i++) {
        printf("%d\t%d\t%d\t%d\t\t%d\t%d\n",
               p[i].pid, p[i].arrivalTime, p[i].burstTime,
               p[i].completionTime, p[i].turnaroundTime, p[i].waitingTime);
        avgWT += p[i].waitingTime;
        avgTAT += p[i].turnaroundTime;
    }

    printf("\nAverage Waiting Time: %.2f", avgWT/n);
    printf("\nAverage Turnaround Time: %.2f\n", avgTAT/n);

    return 0;
}
