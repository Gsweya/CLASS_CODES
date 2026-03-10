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


    Node* top = NULL, *temp;

    // Push 

    for (int i = 0; i < 9; i++) {
        Node* newNode = new Node;
        newNode->name = names[i];
        newNode->age = myNumber[i];
        newNode->next = top;
        top = newNode;

    }

    // Pop 

    temp = top;
    Node* pop;
    while (temp != NULL) {
        cout << temp->name << " - " << temp->age << endl;

        pop = temp;
        temp = temp->next;

        top = pop->next;
        pop->next = nullptr;
        delete pop;   
    }


}