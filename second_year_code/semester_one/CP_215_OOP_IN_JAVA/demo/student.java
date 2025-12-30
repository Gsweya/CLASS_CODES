package demo;
import java.util.*;


class student {

    public String name;
    private int age;
    private String grade;

    public student(String name, int age, String grade){
        this.name = name;
        this.age = age;
        this.grade = grade;
    }

    public void getInfo(){
        System.out.println("My name is: " + name);
        System.out.printf("I am %d years old, and in grade %s\n", age, grade);
    }

    public int getAge(){
        return age;
    }


    public static void main(String[] args){
        student student_one = new student("Galanda", 18, "5th grade");
        student student_two = new student("James", 19, "8th grade");
        
        student_one.getInfo();
        student_two.getInfo();
        
    }

}

