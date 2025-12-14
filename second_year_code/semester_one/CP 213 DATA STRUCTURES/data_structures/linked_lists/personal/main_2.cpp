#include <iostream>
using namespace std;


struct Node {
    int data;
    Node* next;

};

// Function to print list 
void printList(Node* head) {
    Node* current = head; 
    while (current != nullptr) {
        cout << current->data << " -> ";
        current = current->next;
    }

    cout << "NULL\n";
}

// Insert at head 
void insertAtHead(Node*& head, int value) {
    Node* newNode = new Node{value, head};
    head = newNode;
}

// Insert at tail 
void insertAtTail(Node*& head, int value) {
    Node* newNode = new Node{value, nullptr};
    if (!head) {
        head = newNode;
        return;
    }

    Node* temp = head;
    while (temp->next != nullptr) {
        temp = temp->next;
    }
    temp->next = newNode;
}

// Delete head 
void deleteHead(Node*& head) {
    if (!head) return;
    Node* temp = head;
    head = head->next;
    delete temp;
}

// Delete tail 
void deleteTail(Node*& head) {
    if (!head) return;
    if (!head->next) { // only one node 
        delete head;
        head = nullptr;
        return;
    }

    Node* temp = head;
    while (temp->next->next != nullptr) { // go to second last node
        temp = temp->next;

    }
    delete temp->next;
    temp->next = nullptr;

}

// Search for value 
bool search(Node* head, int value) {
    Node* temp = head;
    while (temp) {
        if (temp->data == value) return true;
        temp = temp->next;
    }

    return false;
}


int main() {
    Node* head = nullptr; // empty list 
    
    insertAtHead(head, 3); //3
    insertAtHead(head, 2); // 2 -> 3 
    insertAtTail(head, 5); // 2 -> 3 -> 5

    printList(head);

    deleteHead(head); // 3 -> 5
    deleteTail(head); // 3

    printList(head);

    cout  << "Search 3: " << (search(head, 3) ? "Found\n" : "Not Found\n");
    cout  << "Search 4: " << (search(head, 4) ? "Found\n" : "Not Found\n");


    return 0;
}


