#include <iostream>
#include <thread>
#include <atomic>

std::atomic<int> turn(1);
std::atomic<bool> completed(false);



void Thread1 () {

    do {

        // Entry section
        while(turn == 2);
        // Busy waiting

        // Thread One critical section

        std::cout << "Thread 1 is running\n";
        std::cout << "I am in the CPU now!!!\n";
        std::this_thread::sleep_for(std::chrono::seconds(30));

        // Thread One critical section


        turn = 2;

    } while (!completed);
}


void Thread2() {

    do {
        while (turn == 1);
        // Busy waiting

        std::cout << "Thread 2 is running\n";
        std::this_thread::sleep_for(std::chrono::seconds(30));

        turn = 1;
    } while (!completed);

}



int main()
{

    std::thread t1(Thread1);
    std::thread t2(Thread2);

    std::this_thread::sleep_for(std::chrono::seconds(30));

    completed = true;

    t1.join();
    t2.join();



    return 0;
}
