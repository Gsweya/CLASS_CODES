package CP_215_OOP_IN_JAVA.assignments.practical_3;

import java.util.Scanner;

public class QuestionFive {

    public static void main(String[] args) {
        Scanner input = new Scanner(System.in);
        final int TOTAL_TEMPERATURES = 15;

        System.out.println("=== FAHRENHEIT TO CELSIUS CONVERTER ===");

        for (int i = 1; i <= TOTAL_TEMPERATURES; i++) {
            System.out.print("Enter Fahrenheit temperature " + i + ": ");
            double fahrenheit = input.nextDouble();

            // Conversion formula: C = (F - 32) * 5/9
            double celsius = (fahrenheit - 32) * 5 / 9;
            System.out.printf("Celsius temperature %d: %.2f%n", i, celsius);
        }

        System.out.println("All temperatures processed");
        input.close();
    }
}
