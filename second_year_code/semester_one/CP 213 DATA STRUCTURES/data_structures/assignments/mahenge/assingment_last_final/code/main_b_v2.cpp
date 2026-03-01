#include <iostream>
using namespace std;

struct Thief {
    int convictNumber;
    string name;
    string gang;
    Thief* next;
};

int main() {
    Thief* front = nullptr;
    Thief* rear = nullptr;

    for (int i = 1; i <= 15; i++) {
        Thief* newThief = new Thief;
        newThief->convictNumber = 100 + i;
        newThief->name = "Thief";
        newThief->gang = "Gang";
        newThief->next = nullptr;

        if (front == nullptr) {
            front = rear = newThief;
        } else {
            rear->next = newThief;
            rear = newThief;
        }
    }

    cout << "Exiting Order of the Thieves:" << endl;

    while (front != nullptr) {
        Thief* temp = front;
        cout << temp->convictNumber << " " << temp->name << " " << temp->gang << endl;
        front = front->next;

        temp->next = nullptr;
        delete temp;
    }

    return 0;
}
