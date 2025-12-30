
class Complex {
    private int a, b;

    // constructor with 2 parameters 
    private Complex(int i, int j) {
        this.a = i;
        this.b = j;
    }

    // Constructor with single parameter 
    private Complex(int i) {
        // invoces the constructor with 2 paramters
        this(i, i);
    }

    // Constructor with no parameter 
    private Complex() {
        // invokes the constructor with single parameter 
        this(0);
    }

    @Override
    public String toString() {
        return this.a + " + " + this.b + "i";
    }

    public static void main(String[] args) {

        // creating object of Complex class 
        // calls the constructor with 2 parameter
        Complex c1 = new Complex(2, 3);

        // calls the constructor with a single parameter 
        Complex c2 = new Complex(3);

        // calls the constructor with no parameters 
        Complex c3 = new Complex();

        // print objects 
        System.out.println(c1);
        System.out.println(c2);
        System.out.println(c3);

    }
}