#include <iostream>
using namespace std;

struct Node {
    int data;
    Node* next;
};

void insertAtBeginning(Node*& head,int data){
    Node* newNode = new Node;
    newNode->data = data;
    newNode->next = head;
    head = newNode;
}

void insertAtEnd(Node*&head, int data){
    Node* newNode = new Node;
    newNode->data = data;

    // can use trav (implicit of the teacher- if names not given*)
    Node* current = head;
    while (current->next != nullptr){
        current = current->next;
    }

    current->next = newNode;
}

void insertAtPos(Node*& head, int data, int point){
    Node* newNode = new Node;
    newNode->data = data;
    newNode->next = nullptr;

    Node* trav = head;
    while(trav->data = point){
        newNode->next = trav->next;
        trav->next = newNode;
    }
}



int main() {

    Node* head = nullptr;


    // Print Linked List
    Node* current = head;
    while (current->next != nullptr){
        cout << current->data << " -> ";
        current = current->next;
    }

    cout << "NULL" << endl;

    return 0;
}
