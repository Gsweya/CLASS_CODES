package CP_215_OOP_IN_JAVA.assignments.practical_3;
import java.util.Scanner;


public class QuestionThree {

    static int num;

    public static int findFactorialForLoop(int num){

        int product = 1;
        
        // Factorial using a for loop.
        for (int i = num; i > 0; i--){
            product = product * i;
        }

        return product;
    }

    public static int findFactorialWhileLoop(int num){

        int product = 1;        
        int i = num;

        // Factorial using a while loop.
        while (i > 0){
            product = product * i;
            i --;

        }

        return product;
    }

    public static int findFactorialdoWhileLoop(int num){

        // Handle 0 explicitly; 0! = 1.
        if (num == 0) {
            return 1;
        }

        int product = 1;
        int i = num;

        // Factorial using a do-while loop.
        do {
            product = product * i;
            i--;
        } while (i > 0);

        return product;
    }

    public static void main(String[] args){

        Scanner input = new Scanner(System.in);

        System.out.println("=== PROGRAM TO FIND THE FACTORIAL OF A NUMBER ===");
        System.out.print("Enter the Number: ");
        num = input.nextInt();

        if (num < 0) {
            System.out.println("Error! Factorial is not defined for negative integers.");
            input.close();
            return;
        }

        System.out.println("----------------------------------------");
        System.out.println("The factorial (For Loop) is: " + findFactorialForLoop(num));
        System.out.println("The factorial (While Loop) is: " + findFactorialWhileLoop(num));
        System.out.println("The factorial (Do-While Loop) is: " + findFactorialdoWhileLoop(num));

        input.close();

    }
    
}
