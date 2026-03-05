// Class with constructor that can fail.
class SomeClass {

    int age;

    public SomeClass(int age) throws Exception {
        // Simulate constructor failure.
        if (age < 18){
            throw new Exception("Cannot be registered if less than 18.");
        } else {
            this.age = age;
        }
        
    }
}

public class QuestionFour {
    public static void main(String[] args) {
        try {
            // Try to create object.
            SomeClass object = new SomeClass(15);
            System.out.println("Object created successfully!");

        } catch (Exception e) {
            // Catch exception thrown by constructor.
            System.out.println("Caught exception from constructor: " + e.getMessage());
        }
    }
}
