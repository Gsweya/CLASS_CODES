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

    Node* front = nullptr, *rear = nullptr, *temp;

    // Enqueue 

    for (int i = 0; i < 9; i++){
        Node* newNode = new Node;
        newNode->name = names[i];
        newNode->age = myNumber[i];
        newNode->next = NULL;


        if (front == NULL) {
            front = rear = newNode;
        }

        else {
            
            rear->next = newNode;
            rear = newNode;            
        }
    }

    // Display / Dequeue 

    temp = front;
    
    Node* dequeue;
    while (temp != nullptr) {
        cout << temp->name << " - " << temp->age << endl;

        dequeue = temp;
        temp = temp->next;
        
        // Not sure if you have to pop this as well here, tried
        // but getting a segmentation error, but so far this thing works.. 
    }

    return 0;
}