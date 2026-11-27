#include <unistd.h>
#include <iostream>

using namespace std;


pid_t fork(void);


int main() {

    pid_t childPid; /* Used in parent after successful fok()
                    to record PID of child */
    switch (childPid = fork())
    {
        case -1:
        /* Handle error */
            cout << "-1" << endl;

        case 0:
        /* Perform actions specific to child */
            cout << "0" << endl;

        default:                                /* Parent comes here after successful fork() */
        /* Perform actions specific to parent  */
        break;
    }

    return 0;

}
