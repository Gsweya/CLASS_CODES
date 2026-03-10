#include <iostream>
using namespace std;

struct Node {
    string name;
    int age;
    Node* next;
};

int main() {
    int myNumber[9] = {70, 10, 2, 15, 40, 16, 80, 50, 60};

    string names[9] = {
        "Anna", "Isaac", "Musa", "Issa", "Naima",
        "Asia", "Juma", "Kisha", "Jamal"
    };

    Node* head = NULL;
    Node* temp;

    for (int i=0; i< 9; i++) {
        Node* newNode = new Node;
        newNode->name = names[i];
        newNode->age = myNumber[i];
        newNode->next = NULL;

        if (head == NULL) {
            head = newNode;
        }

        else {
            temp = head;
            while (temp-> next != NULL) {
                temp = temp->next;
            }

            temp->next = newNode;
        }
    }


    temp = head;

    while (temp != NULL) {
        cout << temp->name << " - " << temp->age << endl;
        temp = temp->next;
    }

    return 0;
}