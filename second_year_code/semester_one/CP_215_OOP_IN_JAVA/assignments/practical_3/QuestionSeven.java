package CP_215_OOP_IN_JAVA.assignments.practical_3;

import java.util.Scanner;

public class QuestionSeven {

    public static void main(String[] args) {
        Scanner input = new Scanner(System.in);
        int[] numbers = new int[20];

        System.out.println("=== ARRAY INPUT AND DISPLAY ===");

        for (int i = 0; i < numbers.length; i++) {
            System.out.print("Enter integer " + (i + 1) + ": ");
            numbers[i] = input.nextInt();
        }

        System.out.println("\nDisplay using normal for loop:");
        for (int i = 0; i < numbers.length; i++) {
            System.out.println("numbers[" + i + "] = " + numbers[i]);
        }

        System.out.println("\nDisplay using enhanced for loop:");
        int index = 0;
        for (int value : numbers) {
            System.out.println("numbers[" + index + "] = " + value);
            index++;
        }

        input.close();
    }
}
