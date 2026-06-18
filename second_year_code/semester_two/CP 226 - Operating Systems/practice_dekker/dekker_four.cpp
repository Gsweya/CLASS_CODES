#include <iostream>
#include <thread>
#include <atomic>


std::atomic<bool> thread1WantsToEnter(false);
std::atomic<bool> thread2WantsToEnter(false);

std::atomic<bool> completed(false);


void Thread1() {

    do {

        // Entry section

        thread1WantsToEnter = true;

        while (thread2WantsToEnter == true) {

            thread1WantsToEnter = false;

            // wait a bit (optional)
            // std::this_thread::yield();

            thread1WantsToEnter = true;
        } 

        // Critical Section
        std::cout << "Thread 1 in critical section\n";
        std::cout << "Running on a weid loop here\n";

        thread1WantsToEnter = false;
    } while (!completed);


}

void Thread2() {

    do {

        // Entry section
        
        thread2WantsToEnter = true;

        while (thread1WantsToEnter == true) {
            thread2WantsToEnter = false;

            // std::this_thread::yield();

            thread2WantsToEnter = true;
        }

        // Critical Section
        std::cout << "Thread 2 is running in a critical section\n";
        std::cout << "Running in the void fn()\n";

        thread2WantsToEnter = false;

    } while (!completed);
}

int main() {

    std::thread t1(Thread1);
    std::thread t2(Thread2);

    std::this_thread::sleep_for(std::chrono::seconds(5));

    completed = true;

    t1.join();
    t2.join();

    return 0;
}