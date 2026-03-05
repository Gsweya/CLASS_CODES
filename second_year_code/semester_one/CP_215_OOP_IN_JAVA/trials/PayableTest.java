// 1. Payable Interface

interface Payable {
    double getPaymentAmount();

     
}
 
// 2. Invoice Class
class Invoice implements Payable {
    private String partNumber, partDescription;
    private int quantity;
    private double pricePerItem;

    public Invoice(String partNumber, String partDescription, int qty, double price) {
        this.partNumber = partNumber;
        this.partDescription = partDescription;
        this.quantity = qty;
        this.pricePerItem = price;
    }
    
    @Override
    public double getPaymentAmount() { 
        return quantity * pricePerItem; 
    }

    @Override
    public String toString() { 
        return "Inovice details\n Part Number" + partNumber + "\nPart Description: " + partDescription
        + "\nPayment Amount: " + getPaymentAmount();
    }

    // setters 


    // getters
    public String getPartNumber(){
        return this.partNumber;
    }

    public String partDescription() {
        return this.partDescription;
    }

    public int getQuantity() {
        return this.quantity;
    }

    public double getPricePerItem() {
        return this.pricePerItem;
    }
}
 
// 3. Employee Class
class Employee implements Payable {
    private String firstName, lastName, employeeID;

    public Employee(String first, String last, String id) {
        this.firstName = first; 
        this.lastName = last; 
        this.employeeID = id;
    }

    @Override
    public double getPaymentAmount() { 
        return 0.0; 
    } // Generic employee, no specific payment
    
    @Override
    public String toString() { return "Employee[name=" + firstName + " " + lastName + ", ID=" + employeeID + "]"; }
    // Getters...
}
 
// 4. SalariedEmployee Class
class SalariedEmployee extends Employee {
    private double salary;
    
    public SalariedEmployee(String first, String last, String id, double weeklySalary) {
        super(first, last, id);
        salary = weeklySalary;
    }
    @Override
    public double getPaymentAmount() { return salary; }
    @Override
    public String toString() { return "SalariedEmployee[" + super.toString() + ", salary=" + salary + "]"; }
}
 
// 5. Test Application
public class PayableTest {
    public static void main(String[] args) {

        Invoice invoice = new Invoice("INV-000", "Tweet!", 29, 300000);
        Employee employee = new Employee("James", "James", "EMP-001");
        SalariedEmployee salaryEmp = new SalariedEmployee("james", "james", "EMP-002", 20000);


        System.out.println("Invoice Payment Amount is: " + invoice.getPaymentAmount());
        System.out.println("Emplyee details: " + employee.toString());
        System.out.println("Salaried Employee Details" + salaryEmp.toString());
       
    }
}

