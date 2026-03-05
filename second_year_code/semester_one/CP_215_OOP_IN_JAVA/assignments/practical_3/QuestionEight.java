package CP_215_OOP_IN_JAVA.assignments.practical_3;

import java.util.Scanner;

public class QuestionEight {

    public static void main(String[] args) {
        Scanner input = new Scanner(System.in);
        int[][] matrix = new int[3][4];

        System.out.println("=== 3 x 4 MATRIX INPUT ===");

        for (int row = 0; row < matrix.length; row++) {
            for (int col = 0; col < matrix[row].length; col++) {
                System.out.print("Enter value for [" + row + "][" + col + "]: ");
                matrix[row][col] = input.nextInt();
            }
        }

        System.out.println("\nStored matrix values:");
        for (int row = 0; row < matrix.length; row++) {
            for (int col = 0; col < matrix[row].length; col++) {
                System.out.print(matrix[row][col] + "\t");
            }
            System.out.println();
        }

        input.close();
    }
}
