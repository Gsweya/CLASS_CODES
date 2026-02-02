#include <iostream>
using namespace std;

struct Node {
    int data;
    Node* next;
};

int linearSearch(Node* head, int target) {
    int index = 0;
    Node* current = head;

    while (current != nullptr) {
        if (current->data == target)
            return index;

        current = current->next; // move the pointer forward 
        index++;
    }

    return -1;
}


int main() {
    Node* head = new Node{10, nullptr};
    head->next = new Node{20, nullptr};
    head->next->next = new Node{30, nullptr};

    int result = linearSearch(head, 20);

    if (result != -1) {
        cout << "Found at index " << result << endl;
    }

    else {
        cout << "Not found" << endl;
    }

    return 0;
}