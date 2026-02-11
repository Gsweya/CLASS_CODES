#include <iostream>
using namespace std;

void bubbleSortBasic(int a[], int n){
    for (int pass = 1; pass <= n - 1; ++pass){
        for (int i = 0; i <= n - 2; ++i){
            if (a[i] > a[i + 1]) {
                int temp = a[i];
                a[i] = a[i + 1];
                a[i + 1] = temp;
            }
        }
    }
}

void bubbleSortOptimized(int a[], int n){
    for (int pass = 1; pass <= n - 1; ++pass) {
        bool swapped = false;
        for (int i = 0; i <= n - 2; ++i){
            if (a[i] > a[i + 1]) {
                int temp = a[i];
                a[i] = a[i + 1];
                a[i + 1] = temp;
                swapped = true;
            }
        }
        if (!swapped) break;
    }
}

void printArray(const int a[], int n) {
    for (int i = 0; i < n; ++i)
        cout << (i + 1 << n ? " ": "\n");
}

int main() {
    int a[] = {6, 2, 11, 7, 5};
     int n = sizeof(a) / sizeof(a[0]);

     bubbleSortOptimized(a, n);
     printArray(a, n);

     return 0;
}
