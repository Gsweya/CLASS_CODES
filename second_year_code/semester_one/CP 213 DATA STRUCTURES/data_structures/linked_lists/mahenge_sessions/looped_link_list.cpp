#include <iostream>
using namespace std;

struct Node {
    int data;
    Node* next;
};

int main() {

    Node* head = nullptr;

    for (int i = 0; i < 5; i++){
        Node* node = new Node;
        cout << "Node " << (i+1) << ": ";
        cin >> node->data;
        node->next = nullptr;

        // If the head is empty, the node is the first node
        if (head == nullptr){
            head = node;
        }


        // Else add the node to the end of the linked list, at the tail
        else {
            // Create a pointer for traversing
            Node* current = head;

            // traverse through the linked list
            while (current-> next != nullptr){
                current = current->next;
            }

            current->next = node;
        }
    }


    // Print Linked List
    Node* current = head;
    while (current->next != nullptr){
        cout << current->data << " -> ";
        current = current->next;
    }

    cout << "NULL" << endl;

    return 0;
}
