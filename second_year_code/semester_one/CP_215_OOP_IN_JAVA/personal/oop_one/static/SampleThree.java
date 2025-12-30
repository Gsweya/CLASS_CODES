
public class SampleThree {

    // static variable
    static int age;

    // static method 
    static void display() {
        System.out.println("Static Method");

    }

    public static void main(String[] args) {
        age = 30;
        System.out.println("Age is " + age);

        // access the static method 
        display();
    }
    
}
