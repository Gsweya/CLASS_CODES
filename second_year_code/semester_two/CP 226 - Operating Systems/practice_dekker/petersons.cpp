#include <iostream>
using namespace std;


void serverA (int i, int j){

    i = 1;
    j = 0;
}

void serverB (int i, int j){

    i = 0;
    j = 1;
}
int main() {

    bool flags[2] = {false, false};

    int i = 0;
    int j = 1;

    flags[i] = true;
    flags[1] = true;



    return 0;
}
