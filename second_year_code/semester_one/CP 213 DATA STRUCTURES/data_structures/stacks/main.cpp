#include <iostream>
using namespace std;

#define SIZE 5

int main() {
    int stack[SIZE]; // array 
    int* base = stack; // points to the first element 
    int* top = stack -1; // top starts "before" the stack 

    // PUSH opetaions 
    if(top < base + SIZE - 1) {
        top++;
        *top = 10;
    }

    if (top < base + SIZE - 1) {
        top++;
        *top = 20;
    }

    if (top < base + SIZE - 1) {
        top++;
        *top = 30;
    }

    // POP operation 
    if (top >= base) {
        cout << "Popped: " << *top << endl;
        top--;
    }

    // DISPLAY stack 
    cout << "Current stack: ";
    for (int* p = base; p <= top; p++) {
        cout << *p << " ";
    }

    return 0;
}