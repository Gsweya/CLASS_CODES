#include <iostream>
#include <thread>
#include <atomic>

std::atomic<bool> thread1(false);
std::atomic<bool> thread2(false);


std::atomic<bool> completed(false);


void Thread1 () {

    do {

        while(thread2 == true);
        // Busy waiting
        
        // Thread One critical section

        std::cout << "Thread 1 is running\n";
        std::cout << "I am in the CPU now!!!\n";
        // Thread One critical section


        thread1 = false;

    } while (!completed);
}


void Thread2() {

    do {
        while (thread1 == true);
        // Busy waiting 

        std::cout << "Thread 2 is running\n";

        thread2 = false;
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
