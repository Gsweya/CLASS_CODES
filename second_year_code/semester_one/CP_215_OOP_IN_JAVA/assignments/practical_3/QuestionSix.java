package CP_215_OOP_IN_JAVA.assignments.practical_3;

import java.util.Scanner;

public class QuestionSix {

    public static void main(String[] args) {
        Scanner input = new Scanner(System.in);

        double totalScore = 0;
        int studentCount = 0;

        System.out.println("=== STUDENT SCORE REPORT ===");
        System.out.println("Enter blank name and score 999 to stop.");
        System.out.println("----------------------------------------");

        while (true) {
            System.out.print("Enter student name: ");
            String name = input.nextLine();

            System.out.print("Enter exam score: ");
            int score = input.nextInt();
            input.nextLine(); // Consume remaining newline.

            // Sentinel record: blank name + 999 means end of input.
            if (name.isBlank() && score == 999) {
                break;
            }

            if (score < 0 || score > 100) {
                System.out.println("Invalid score. Valid range is 0 to 100.");
                System.out.println("----------------------------------------");
                continue;
            }

            System.out.println("Recorded -> Name: " + name + ", Score: " + score);
            System.out.println("----------------------------------------");

            totalScore += score;
            studentCount++;
        }

        if (studentCount == 0) {
            System.out.println("No student records were entered.");
        } else {
            double average = totalScore / studentCount;
            System.out.printf("Class Average: %.2f%n", average);
        }

        input.close();
    }
}
