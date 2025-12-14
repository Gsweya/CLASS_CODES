#include <iostream>
using namespace std;

struct Node {
    int data;  // Data field
    Node* link; // Pointer to next node 
};

Node* head = nullptr; // Head pointer


int main() {
    Node* node1 = new Node;
    node1->data = 10;

    Node* node2 = new Node;
    node2->data = 20;

    Node* node3 = new Node;
    node3->data = 40;

    // Link them together 
    node1->link = node2;
    node2->link = node3;
    node3->link = nullptr;

    //Set head pointer 
    head = node1;

    cout << node3->data << endl;
    cout << (*node2).data << endl;
}
