#include <iostream>
using namespace std;
// linked list, easily adding nodes, by using a tail
struct Node {
    int data;
    Node* next;
};

int main() {

    Node* head = nullptr;
    Node* tail = nullptr;

    for (int i = 0; i < 5; i++){
        Node* node = new Node;
        cout << "Node " << (i+1) << ": ";
        cin >> node->data;
        node->next = nullptr;

        // If the head is empty, the node is the first node
        if (head == nullptr){
            head = tail = node;
        }


        // else update the tail
        else {
            tail->next = node;
            tail = node;
        }
    }

    // Print Linked List
    Node* current = head;
    while (current != nullptr){
        cout << current->data << " -> ";
        current = current->next;
    }

    cout << "NULL" << endl;

    return 0;
}
