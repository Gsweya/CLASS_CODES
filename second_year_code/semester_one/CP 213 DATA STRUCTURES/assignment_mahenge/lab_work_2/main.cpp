#include <iostream>
using namespace std;


struct Node {
    int serial_no;
    string phone_name;
    string imei_no;
    int price;
    Node* next;
};


int main() {

    Node* head = nullptr;
    Node* tail = nullptr;

    // !!! done while considering b) as the main directing point
    // a and b share almost the same concepts....
    for (int i = 1; i <= 10; i++){
        
        Node* newNode = new Node;

        newNode->serial_no = i;
        cout << "Phone Name: ";       
        cin >> newNode->phone_name;
        
        cout << "IMEI Number: ";
        cin >> newNode->imei_no;

        newNode->price = 25000;

        if (head == nullptr) {
            head = newNode;
            tail = newNode;
        }
        else {
            tail->next = newNode;
            tail = newNode;
        }
    }

    Node* trav = head;
    int total = 0;

    cout << "S\\/N\t\tMobile Phonenumber\t\tIMEI\t\tPrice" << endl;    

    while (trav != nullptr) {
        cout << trav->serial_no << "\t\t" << trav->phone_name << "\t\t"
             << trav->imei_no << "\t\t" << trav->price << endl;


        total += trav->price;

        trav = trav->next;
    }

    cout << "Total Sales: " << total << endl;
    
    return 0;
}