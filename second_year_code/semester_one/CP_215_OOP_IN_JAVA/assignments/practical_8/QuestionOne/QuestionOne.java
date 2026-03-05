// Custom parent exception class.
class RegistrationFail extends Exception {
    public RegistrationFail(String message) {
        super(message);
    }
}

// ExceptionB is a child of RegistrationFail.
class ExceptionB extends RegistrationFail {
    public ExceptionB(String message) {
        super(message);
    }
}

// ExceptionC is a child of ExceptionB.
class ExceptionC extends ExceptionB {
    public ExceptionC(String message) {
        super(message);
    }
}

public class QuestionOne {
    public static void main(String[] args) {
        // First test: throw ExceptionB and catch it using RegistrationFail.
        try {
            throw new ExceptionB("Registration Failed.");
        } catch (RegistrationFail e) {
            System.out.println("Caught by RegistrationFail catch block: " + e.getMessage());
        }

        // Second test: throw ExceptionC and catch it using RegistrationFail.
        try {
            throw new ExceptionC("This is ExceptionC.");
        } catch (RegistrationFail e) {
            System.out.println("Caught by RegistrationFail catch block: " + e.getMessage());
        }
    }
}
