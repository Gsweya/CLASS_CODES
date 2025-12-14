#include <iostream>
using namespace std;

// Define the Node structure with a pointer to the next node 

struct Node {
    int data;
    Node* next; // Ponter to the next node 
};


// Insert at the beggining 
Node* insertAtBeginning(Node* head, int value) {
    Node* newNode = new Node();
    newNode->data = value;
    newNode->next = head;
    cout << "Inserted " << value << " at beginning" << endl;
    return newNode;
}

// Insert at a specific postion (0-indexed)
void insertAtPostion(Node* head, int value, int position) {
    if (position == 0) {
        head = insertAtBeginning(head, value);
        return;
    }

    Node* temp = head;
    for (int i = 0; i < position - 1; i++) {
        if (temp == nullptr) {
            cout << "Position out of bounds" << endl;
            return;
        }
        temp = temp->next;
    }

    if (temp == nullptr) {
        cout << "Position out of bounds" << endl;
        return;
    }

    Node* newNode = new Node();
    newNode->data = value;
    newNode->next = temp->next;
    temp->next = newNode;
    cout << "Inserted " << value << " at position " << position << endl;

}

void insertAtEnd(Node* head, int value) {
    Node* newNode = new Node();
    newNode->data = value;
    newNode->next = nullptr;

    if (head == nullptr) {
        cout << "List is empty" << endl;
        return;
    }

    Node* temp = head;
    while(temp->next != nullptr) {
        temp = temp->next;
    }
    temp->next = newNode;
    cout << "Inserted " << value << " at end" << endl;
}

// Delete from the beginning 
Node* deleteFromBeginning(Node* head) {
    if (head == nullptr) {
        cout << "List is empty" << endl;
        return nullptr;
    }

    Node* temp = head;
    cout << "Deleted " << head->data << " from beginning" << endl;
    head = head->next;
    delete temp;
    return head;
}

// Delete from specific position 
void deleteFromPosition(Node* head, int position) {
    if (head == nullptr || position < 0) {
        cout << "List is empty or invalid position" << endl;
        return;
    }

    if (position == 0) {
        head = deleteFromBeginning(head);
        return;
    }

    Node* temp = head;
    for (int i = 0; i < position - 1; i++) {
        if (temp == nullptr || temp->next == nullptr) {
            cout << "Position out of bounds" << endl;
            return;
        }
        temp = temp->next;
    }

    if (temp->next == nullptr) {
        cout <<"Position out of bounds" << endl;
        return;
    }

    Node* nodeToDelete = temp->next;
    cout << "Deleted " <<  nodeToDelete->data << " from postion " << position << endl;
    temp->next = nodeToDelete->next;
    delete nodeToDelete;
}

// Delete from the end 
Node* deletefromEnd(Node* head) {
    if (head == nullptr) {
        cout << "List is empty" << endl;
        return nullptr;
    }

    if (head->next == nullptr) {
        cout << "Deleted " << head->data << " from end" << endl;
        delete head;
        return nullptr;

    }

    Node* temp = head;
    while (temp->next->next != nullptr) {
        temp = temp->next;
    }

    cout << "Deleted " << temp->next->data << " from end" << endl;
    delete temp->next;
    temp->next = nullptr;
    return head;
}


// Dsiplay the list 
void display(Node* head) {
    if (head == nullptr) {
        cout << "List is empty" << endl;
        return;
    }

    cout << "List: ";
    Node* temp = head;
    while (temp != nullptr) {
        cout << temp->data << " -> ";
        temp = temp->next;
    }

    cout << "null" << endl;
}


int main() {
    Node* head = nullptr;

    cout << "=== Linked List Operations ===" << endl << endl;

    // Insert operations 
    head = insertAtBeginning(head, 10);
    head = insertAtBeginning(head, 5);
    display(head);
    cout << endl;

    insertAtEnd(head, 20);
    insertAtEnd(head, 30);
    display(head);
    cout << endl;

    // Delete operations 
    head = deleteFromBeginning(head);
    display(head);
    cout << endl;

    head = deletefromEnd(head);
    display(head);
    cout << endl;

    deleteFromPosition(head, 1);
    display(head);
    cout << endl;

    return 0;

}