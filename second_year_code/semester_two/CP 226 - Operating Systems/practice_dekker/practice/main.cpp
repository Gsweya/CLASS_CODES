#include <iostream>
#include <thread>
#include <array>
#include <atomic>
using namespace std;

atomic<int> seatsAvailable(1);
array<atomic<bool>, 2> flags{ {false, false} };
atomic<int> turn(0);


void confirmBooking(int x){
    cout << "Seat has been booked!" << endl;
    cout << "From server " << x << endl;
}

void serverA(){
    int i = 0; int j = 1;

    flags[i] = true;
    turn = j;

    while(flags[j] && turn == j){
        cout << "Server A is waiting !!!" << endl;
        cout << "Server A is waiting !!!" << endl;
        this_thread::sleep_for(chrono::seconds(20));

    };


    if(seatsAvailable > 0){
        seatsAvailable = seatsAvailable - 1;
        confirmBooking(0);
        this_thread::sleep_for(chrono::seconds(10));
    } else {
        cout << "Server A failed to buy the tickets." << endl;
    }


    flags[i] = false;

}

void serverB(){
    int j = 0; int i = 1;

    flags[i] = true;
    turn = j;

    while(flags[j] && turn == j){
        cout << "Server B is waiting !!!" << endl;
        cout << "Server B is waiting !!!" << endl;
        this_thread::sleep_for(chrono::seconds(10));
    };

    if(seatsAvailable > 0){
        seatsAvailable = seatsAvailable - 1;
        confirmBooking(1);
        this_thread::sleep_for(chrono::seconds(10));
    } else {
        cout << "Server B failed to buy the tickets" << endl;
    }

    flags[i] = false;

}

int main(){
    thread t1(serverA);
    thread t2(serverB);

    t1.join();
    t2.join();

    return 0;
}
