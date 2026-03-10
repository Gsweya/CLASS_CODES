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

    student* top = NULL;


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

        if (top == nullptr) {
            top = newNode;
        } else {
            newNode->next = top;
            top = newNode;
        }

    }

    student* pop = top;

    while (pop != nullptr){

        student* temp = pop;

        cout << "==== SURVEYED STUDENTS ==== " << endl;

        cout << "SURNAME\t\t" << "REG NO\t\t" << "AGE\t\t" <<
                "WEIGHT\t\t" << "HEIGHT\t\t" << endl;

        
        cout << pop->surname << "t\t" << pop->registration_number <<
            pop->age << "t\t" << pop->weight << "\t\t" << 
            pop->height << endl;

        pop = pop->next;

        top = top->next;
        temp->next = nullptr;
        delete temp;
    }
    
    return 0;
}