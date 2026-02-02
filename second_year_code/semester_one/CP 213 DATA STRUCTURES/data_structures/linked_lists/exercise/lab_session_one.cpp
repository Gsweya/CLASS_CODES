#include <iostream>
#include <iomanip>
#include <string>

using namespace std;

struct phone {
    string phone_name;
    string imei_no;
    double price;
    phone* link;
};

void addPhone(phone*& head, string phone_name, string imei_no, double price){
    // 1. Create new phone Node
    phone* newPhone = new phone{phone_name, imei_no, price, nullptr};

    // 2. Traverse to the end of the linked list
    phone* current = head;

    if (head == nullptr){
        head = newPhone;
    }
    else {

        while (current->link != nullptr){
            current = current->link;
        }

        // 3. Add the new phone to the end of the list
        current->link = newPhone;

    }
}

void SalesReport(phone* head){

    phone* current = head;
    int counter = 1;
    double sales = 0;
    cout <<  " ===========    PHONE STORE SALES REPORT    ============" << endl;
    cout << left << setw(15) << "S/N"
         << right << setw(15) << "Mobile Phone Name"
         << right << setw(15) << "IMEI"
         << right << setw(15) << fixed << "Price" << "\n";

    cout << setfill('-') << setw(15*6) << "" << setfill(' ') << "\n";
    // cout << "S/N" << setw(20) << "Mobile Phone Name" << setw(20) << "IME" << setw(20) << "Price" << endl;

    while (current != nullptr){
        cout << left << setw(15) << counter
             << right << setw(15) << current->phone_name
             << right << setw(15) << current->imei_no
             << right << setw(15) << fixed << setprecision(2) << current->price << "\n";

        sales += current->price;
        counter++;
        current = current->link;
    }

    cout << "Total Sales: " << sales << endl;

}


int main() {

    phone* head = nullptr;
    string phone_name, imei_no;
    double price;

    cout << " ==== PHONE STORE PROGRAM ==== " << endl;
    cout << "ENTER the sales details of the phones." << endl;

    for (int i = 1; i <= 7; i++){
        cout << "Phone Name: ";
        getline(cin, phone_name);
        cout << "IME: ";
        getline(cin, imei_no);
        addPhone(head, phone_name, imei_no, 25000);

    }

    cout << endl;
    SalesReport(head);

    return 0;
}
