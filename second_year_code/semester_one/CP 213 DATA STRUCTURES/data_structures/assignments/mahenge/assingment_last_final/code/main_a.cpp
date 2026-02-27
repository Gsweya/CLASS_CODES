#include <iostream>
using namespace std;

struct Thief {
    int convictNumber;
    string name;
    string gang;
    Thief* next;
};

void push(Thief*& top, int num, string name, string gang) {
    Thief* newThief = new Thief;
    newThief->convictNumber = num;
    newThief->name = name;
    newThief->gang = gang;
    newThief->next = top;
    top = newThief;
}

void pop(Thief*& top) {
    if (top == nullptr) {
        return;
    }

    Thief* temp = top;
    cout << temp->convictNumber << " " << temp->name << " " << temp->gang << endl;
    top = top->next;

    temp->next = nullptr;
    delete temp;
}

int main() {

    Thief* top = nullptr;

    for (int i = 1; i <= 15; i++) {
        push(top, 100 + i, "Thief", "Gang");
    }

    cout << "Exit Order of the Thieves: " << endl;

    while (top != nullptr) {
        pop(top);
    }

    return 0;
}