#include <iostream>
#include <thread>
#include <atomic>

std::atomic<int> favouredThread(1);

std::atomic<bool>  thread1WantsToEnter(false);
std::atomic<bool> thread2WantsToEnter(false);

std::atomic<bool> completed(false);


void Thread1()
{
    do
    {

        thread1WantsToEnter = true;

        while  (thread2WantsToEnter)
        {
            if (favouredThread  == 2)
            {

                thread1WantsToEnter =  false;
                
                while (favouredThread == 2)
                {
                    // busy waiting
                }

                thread1WantsToEnter = true;
            }
        }

        //  Critical Section

        std::cout << "Thread 1 is running\n";
        std::cout << "Thread 1 is in the critical section.\n";
        
        // Exit Section 
        favouredThread = 2;
        thread1WantsToEnter = false;

    } while (!completed);
    
}

void Thread2()
{
    do 
    {

        // Entry section
        thread2WantsToEnter = true;
        while (thread1WantsToEnter)
        {
            if (favouredThread == 1){
                thread2WantsToEnter = false;

                while (favouredThread == 1)
                {
                    // busy waiting
                }


                thread2WantsToEnter = true;
            }           
            
        }

        // Critical Section
        std::cout << "Thread 2 is running\n";
        std::cout << "Thread 2 is in the critical section\n";

        favouredThread = 1;
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