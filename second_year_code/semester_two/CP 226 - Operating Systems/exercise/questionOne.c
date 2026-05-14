#include "stdio.h"
#include "unistd.h"
#include "sys/wait.h"
#include "stdlib.h"


int main() {

    fork();
    fork();
    fork();

    return 0;
}
