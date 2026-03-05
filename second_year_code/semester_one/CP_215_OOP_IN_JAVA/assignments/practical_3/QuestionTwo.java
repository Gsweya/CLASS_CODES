package CP_215_OOP_IN_JAVA.assignments.practical_3;
import java.util.Scanner;

public class QuestionTwo {

    static float marks;
    static String grade = "";

    public static void main(String[] args) {

        Scanner input = new Scanner(System.in);

        System.out.println("===== GRADE DESCRIPTION PROGRAM =====");
        System.out.print("Enter student marks (0-100): ");
        marks = input.nextFloat();

        // First map marks to a grade using if-else.
        if (marks >= 0 && marks <= 100) {
            if (marks >= 0 && marks < 40) {
                grade = "C";
            }
            else if (marks >= 40 && marks < 70) {
                grade = "B";
            }
            else {
                grade = "A";
            }
        }
        else {
            System.out.println("Error! Invalid input");
            input.close();
            return;
        }

        // Use switch exactly as requested in the assignment.
        switch(grade) {
            case "A" -> System.out.println("Very Good");
            case "B" -> System.out.println("Good");
            case "C" -> System.out.println("Bad");
            default -> System.out.println("Wrong Input");
        }

        input.close();
    }
    
}
