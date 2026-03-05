package CP_215_OOP_IN_JAVA.assignments.practical_3;

import java.util.Arrays;
import java.util.Scanner;

public class QuestionNine {

    public static int[] sortAscending(int[] values) {
        int[] copy = Arrays.copyOf(values, values.length);
        Arrays.sort(copy);
        return copy;
    }

    public static int[] sortDescending(int[] values) {
        int[] asc = sortAscending(values);
        int[] desc = new int[asc.length];

        for (int i = 0; i < asc.length; i++) {
            desc[i] = asc[asc.length - 1 - i];
        }
        return desc;
    }

    public static long sumArray(int[] values) {
        long sum = 0;
        for (int value : values) {
            sum += value;
        }
        return sum;
    }

    public static int[] flatten2D(int[][] matrix) {
        int[] flat = new int[matrix.length * matrix[0].length];
        int index = 0;

        for (int[] row : matrix) {
            for (int value : row) {
                flat[index++] = value;
            }
        }
        return flat;
    }

    public static void main(String[] args) {
        Scanner input = new Scanner(System.in);
        final int SIZE = 100;

        int[] oneDim = new int[SIZE];
        int[][] twoDim = new int[10][10];

        System.out.println("=== QUESTION 9: ARRAY OPERATIONS ===");
        System.out.println("Enter 100 integer values:");

        // Read values into 1D array, then place the same values into 2D array.
        for (int i = 0; i < SIZE; i++) {
            System.out.print("Value " + (i + 1) + ": ");
            oneDim[i] = input.nextInt();

            int row = i / 10;
            int col = i % 10;
            twoDim[row][col] = oneDim[i];
        }

        long sum1D = sumArray(oneDim);
        double avg1D = (double) sum1D / oneDim.length;
        int[] asc1D = sortAscending(oneDim);
        int[] desc1D = sortDescending(oneDim);

        int[] twoDimFlat = flatten2D(twoDim);
        long sum2D = sumArray(twoDimFlat);
        double avg2D = (double) sum2D / twoDimFlat.length;
        int[] asc2D = sortAscending(twoDimFlat);
        int[] desc2D = sortDescending(twoDimFlat);

        System.out.println("\n--- Single Dimensional Array Results ---");
        System.out.println("Sum: " + sum1D);
        System.out.printf("Average: %.2f%n", avg1D);
        System.out.println("Ascending: " + Arrays.toString(asc1D));
        System.out.println("Descending: " + Arrays.toString(desc1D));

        System.out.println("\n--- Two Dimensional Array Results ---");
        System.out.println("Sum: " + sum2D);
        System.out.printf("Average: %.2f%n", avg2D);
        System.out.println("Ascending: " + Arrays.toString(asc2D));
        System.out.println("Descending: " + Arrays.toString(desc2D));

        input.close();
    }
}
