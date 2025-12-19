#include <iostream>
#include <vector>
using namespace std;

class Stack {
    vector<int> data;

    public:
        void push(int value) {
            data.push_back(value);
        }

        void pop() {
            if (!data.empty())
                data.pop_back();
        }
        
        int top() {
            return data.back();
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


    cout << s.top() << endl; /// 30 
    s.pop();
    cout << s.top() << endl; // 20
}