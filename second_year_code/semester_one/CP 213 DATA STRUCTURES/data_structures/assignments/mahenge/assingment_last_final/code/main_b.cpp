#include <iostream>
using namespace std;

struct Thief {
    int convictNumber;
    string name;
    string gang;
    Thief* next;
};

void enqueue(Thief*& front, Thief*& rear, int num, string name, string gang) {
    Thief* newThief = new Thief;
    newThief->convictNumber = num;
    newThief->name = name;
    newThief->gang = gang;
    newThief->next = nullptr;

    if (front == nullptr) {
        front = rear = newThief;
    } else {
        rear->next = newThief;
        rear = newThief;
    }
}

void dequeue(Thief*& front) {
    if (front == nullptr) {
        return;
    }

    Thief* temp = front;

    cout << temp->convictNumber << " " << temp->name << " " << temp->gang << endl;
    front = front->next;

    temp->next = nullptr;
    delete temp;
}

int main() {

    Thief* front = nullptr;
    Thief* rear = nullptr;

    // Insert 15 thieves
    for (int i = 1; i <= 15; i++) {
        enqueue(front, rear, 100 + i, "Thief", "Gang");
    }

    cout << "Exiting Order of the Thieves:" << endl;

    while (front != nullptr) {
        dequeue(front);
    }

    return 0;
}