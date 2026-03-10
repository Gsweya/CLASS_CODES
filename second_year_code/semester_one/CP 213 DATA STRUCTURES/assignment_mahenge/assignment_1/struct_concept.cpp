#include <iostream>
using namespace std;

struct Member {
    string name;
    int age;
};

int main() {
    int myNumber[9] = {70, 10, 2, 15, 40, 16, 80, 50, 60};

    string names[9] = {
        "Anna", "Isaac", "Musa", "Issa", "Naima",
        "Asia", "Juma", "Kisha", "Jamal"
    };

    Member group[9];

    for (int i=0; i < 9; i++){
        group[i].name = names[i];
        group[i].age = myNumber[i];
    }

    cout <<  "Group Members\n";
    for (int i = 0; i < 9; i++) {
        cout << group[i].name << " - " << group[i].age << endl;
    }
}