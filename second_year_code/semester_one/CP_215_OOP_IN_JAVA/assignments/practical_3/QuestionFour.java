package CP_215_OOP_IN_JAVA.assignments.practical_3;

import java.util.Scanner;

public class QuestionFour {

    public static void main(String[] args) {
        Scanner input = new Scanner(System.in);

        System.out.println("=== SALES TAX CALCULATOR ===");
        System.out.print("Enter customer name: ");
        String customerName = input.nextLine();

        System.out.print("Enter purchase amount: ");
        double purchaseAmount = input.nextDouble();

        System.out.print("Enter tax code (0, 1, 2, 3): ");
        int taxCode = input.nextInt();

        // Map tax code to rate based on assignment table.
        double taxRate = switch (taxCode) {
            case 0 -> 0.00;
            case 1 -> 0.03;
            case 2 -> 0.05;
            case 3 -> 0.07;
            default -> -1.0;
        };

        if (taxRate < 0) {
            System.out.println("Error! Invalid tax code.");
            input.close();
            return;
        }

        double salesTax = purchaseAmount * taxRate;
        double totalAmountDue = purchaseAmount + salesTax;

        System.out.println("\n--- Customer Bill ---");
        System.out.println("Name: " + customerName);
        System.out.printf("Purchase Amount: %.2f%n", purchaseAmount);
        System.out.printf("Sales Tax: %.2f%n", salesTax);
        System.out.printf("Total Amount Due: %.2f%n", totalAmountDue);

        input.close();
    }
}
