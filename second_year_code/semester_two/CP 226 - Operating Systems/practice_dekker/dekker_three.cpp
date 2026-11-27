#include <iostream>
#include <thread>
#include <atomic>

std::atomic<bool> thread1WantsToEnter(false);
std::atomic<bool> thread2WantsToEnter(false);

std::atomic<bool> completed(false);

void Thread1 () {

    do {

        thread1WantsToEnter = true;

        while(thread2WantsToEnter == true);
        // Busy waiting

        // Critical section 
        std::cout << "Thread 1 is in critical section\n";
        std::cout << "Running in the dummy....\n";

        // Exit section
        thread1WantsToEnter = false;

    }  while (!completed);
}


void Thread2() {

    do {
        thread2WantsToEnter = true;

        while (thread1WantsToEnter == true);
        // Busy waiting 

        // Critical section
        std::cout << "Thread 2 is in critical section.\n";
        std::cout << "We are running in the wilderness";

        // Exit section 
        thread2WantsToEnter = false;

    } while (!completed);

}



int main() 
{

    std::thread t1(Thread1);
    std::thread t2(Thread2);

    std::this_thread::sleep_for(std::chrono::seconds(5));

    completed = true;

    t1.join();
    t2.join();

    return 0;
}
