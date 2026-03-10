#include <iostream>
using namespace std;

struct student {
    
    string surname;
    string registration_number;
    int age;
    float weight;
    float height;
    student* next;
};

int main() {

    student* head = NULL;
    student* tail = NULL;


    for (int i = 0; i < 10; i++){

        student* newNode = new student;

        cout << "Enter Students Records: " << endl;

        cout << "SURNAME:";
        cin >> newNode->surname;

        cout << "REG NO:";
        cin >> newNode->registration_number;

        cout << "AGE: ";
        cin >> newNode->age;

        cout << "WEIGHT: ";
        cin >> newNode->weight;

        cout << "HEIGHT: ";
        cin >> newNode->height;


        if (head == nullptr) {
            head = newNode;
            tail = newNode;
        } 
        else {
            tail->next = newNode;
            tail = newNode;
        }

    }

    student* trav = head;

    while (trav != nullptr){

        cout << "==== SURVEYED STUDENTS ==== " << endl;

        cout << "SURNAME\t\t" << "REG NO\t\t" << "AGE\t\t" <<
                "WEIGHT\t\t" << "HEIGHT\t\t" << endl;

        
        cout << trav->surname << "t\t" << trav->registration_number <<
            trav->age << "t\t" << trav->weight << "\t\t" << 
            trav->height << endl;

        trav = trav->next;
    }
    
    return 0;
}