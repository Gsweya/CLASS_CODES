#include <iostream>
using namespace std;

struct Thief {
    int convictNumber;
    string name;
    string gang;
    Thief* next;
};

int main() {
    Thief* top = nullptr;

    for (int i = 1; i <= 15; i++) {
        Thief* newThief = new Thief;
        newThief->convictNumber = 100 + i;
        newThief->name = "Thief";
        newThief->gang = "Gang";
        newThief->next = top;
        top = newThief;
    }

    cout << "Exit Order of the Thieves: " << endl;

    while (top != nullptr) {
        Thief* temp = top;
        cout << temp->convictNumber << " " << temp->name << " " << temp->gang << endl;
        top = top->next;

        temp->next = nullptr;
        delete temp;
    }

    return 0;
}
