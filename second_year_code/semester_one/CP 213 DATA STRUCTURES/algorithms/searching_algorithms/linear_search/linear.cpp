#include <iostream>
using namespace std;

int linear_search(int array[], int size, int target);
int main() {

    int list[] = {2,3,4,5,6,8};
    int size = sizeof(list) / sizeof(list[0]);

    int x = linear_search(list,size, 5);
    int y = linear_search(list, size, 10);

    if (x >= 0){
        cout << "5 is found at index " << x << endl;

    } 
    else {

        cout << "5 not found." << endl;
    }

    if (y > 0){
        cout << "10 is found at index " << y << endl;

    } 
    else {

        cout << "10 not found." << endl;
    }
    return 0;
}

int linear_search(int array[], int size, int target){

    for (int i = 0; i < size; i++) {
        if (array[i] == target) {
            return i;
        }
    }
    return -1;
}
