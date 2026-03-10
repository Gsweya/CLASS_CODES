#include <iostream>
using namespace std;

struct student {
    
    string surname;
    string registration_number;
    int age;
    float weight;
    float height;
};

int main() {

    student students[10];

    for (int i = 0; i < 10; i++){

        cout << "Enter Students Records: " << endl;

        cout << "SURNAME:";
        cin >> students[i].surname;

        cout << "REG NO:";
        cin >> students[i].registration_number;

        cout << "AGE: ";
        cin >> students[i].age;

        cout << "WEIGHT: ";
        cin >> students[i].weight;

        cout << "HEIGHT: ";
        cin >> students[i].height;

    }


    // Section to add pupils without regarding the distortion of
    // the previous arrangement... 

    for (int i = 0; i < 4; i++) {
        cout << "SURNAME:";
        cin >> students[i].surname;

        cout << "REG NO:";
        cin >> students[i].registration_number;

        cout << "AGE: ";
        cin >> students[i].age;

        cout << "WEIGHT: ";
        cin >> students[i].weight;

        cout << "HEIGHT: ";
        cin >> students[i].height;
    }

    for (int i = 0; i < 10; i++){

        cout << "==== SURVEYED STUDENTS ==== " << endl;

        cout << "SURNAME\t\t" << "REG NO\t\t" << "AGE\t\t" <<
                "WEIGHT\t\t" << "HEIGHT\t\t" << endl;

        
        cout << students[i].surname << "t\t" << students[i].registration_number <<
            students[i].age << "t\t" << students[i].weight << "\t\t" << 
            students[i].height << endl;

    }
    
    return 0;
}