import java.util.Scanner;

class Circle {

    double radius;

    public void setRadius(double radius) {
        if (radius <= 0) {
            throw new ArithmeticException("Radius cannot be 0, or negative");
        }
        /*OR the following can be implemented
       ArithmeticExpresion e = new ArithmeticExpresion('Radius should not be Zero!');
      throw e; */
        else {
            this.radius = radius;
        }
    }
}

public class CircleTest {

    public static void main(String[] args) {
        Scanner input = new Scanner(System.in);
        Circle c = new Circle();

        double a = input.nextDouble();

        try {
            c.setRadius(a);
        } catch (ArithmeticException e) {
            System.out.println(e.getMessage());
        }

        input.close();
    }
}
