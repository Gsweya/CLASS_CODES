#include <iostream>
#include <list>
using namespace std;

class Stack {
    list<int> data;

    public:
        void push(int value) {
            data.push_front(value);
        }

        void pop() {
            if (!data.empty())
                data.pop_front();
        }

        int top() {
            return data.front();
        }

        bool isEmpty() {
            return data.empty();
        }
};


int main() {
    Stack s;
    s.push(10);
    s.push(20);
    s.push(30);

    cout << s.top() << endl; // 30 

    s.pop();
    cout << s.top() << endl;
}