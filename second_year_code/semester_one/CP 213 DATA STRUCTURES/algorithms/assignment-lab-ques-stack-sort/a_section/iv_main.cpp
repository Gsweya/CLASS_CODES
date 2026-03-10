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

    student* front = NULL;
    student* rear = NULL;


    for (int i = 0; i < 10; i++){

        student* enqueue = new student;

        cout << "Enter Students Records: " << endl;

        cout << "SURNAME:";
        cin >> enqueue->surname;

        cout << "REG NO:";
        cin >> enqueue->registration_number;

        cout << "AGE: ";
        cin >> enqueue->age;

        cout << "WEIGHT: ";
        cin >> enqueue->weight;

        cout << "HEIGHT: ";
        cin >> enqueue->height;

        if (front == nullptr) {
            front = enqueue;
            rear = enqueue;
        } else {
            rear->next = enqueue;
            rear = enqueue;
        }

    }

    student* dequeue = front;

    while (dequeue != nullptr){

        student* temp = dequeue;

        cout << "==== SURVEYED STUDENTS ==== " << endl;

        cout << "SURNAME\t\t" << "REG NO\t\t" << "AGE\t\t" <<
                "WEIGHT\t\t" << "HEIGHT\t\t" << endl;

        
        cout << dequeue->surname << "t\t" << dequeue->registration_number <<
            dequeue->age << "t\t" << dequeue->weight << "\t\t" << 
            dequeue->height << endl;

        dequeue = dequeue->next;

        front = front->next;
        if (front == nullptr){
            rear = nullptr;
        }
        
        temp->next = nullptr;
        delete temp;
    }
    
    return 0;
}