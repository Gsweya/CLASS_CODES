package CLASS_LAB;
abstract class Animal {

    int age;
    String habitat;

    public void eat() {}

    abstract void move();
}

interface Flyable {
    public void fly(int altitude);
    public void land();
}

interface Swimmable {
    public void swim(double depth);
}

class Bird extends Animal implements Flyable {

    @Override
    public void move() {
        System.out.println("Bird is flying");
    }

    @Override
    public void fly(int altitude) {
        System.out.printf("Bird is flying %d m high.\n", altitude);
    }

    @Override
    public void land() {
        System.out.println("Bird has landed.");
    }
}

class Fish extends Animal implements Swimmable {

    @Override
    public void move() {
        System.out.println("The fish is swimming");
    }

    @Override
    public void swim(double depth) {
        System.out.printf("The fish is %d m deep.\n", depth);
    }
}

class Bat extends Animal implements Flyable, Swimmable {

    public void fly(int altitude) {
        System.out.printf("Bat is flying %d m high.\n", altitude);
    }

    public void move() {
        System.out.println("Bat is flying");
    }

    public void land() {
        System.out.println("Bat has landed.");
    }

    public void swim(double depth) {
        System.out.printf("Bat is swimming %.2f m deep.\n", depth);
    }
}

public class MainRun {

    public static void main(String[] args) {
        Animal bird = new Bird();
        Animal fish = new Fish();
        Animal bat = new Bat();

        System.out.println("===== UPCASTING DEMO =====");
        System.out.print("Animal morphs to a bird: ");
        bird.move();

        System.out.print("Animal morphs to a fish: ");
        fish.move();

        System.out.print("Animal morphs to a bat: ");
        bat.move();

        System.out.println("==== DOWNCASTING DEMO =====");
        if (bird instanceof Bird) {
            Bird bird_obj = (Bird) bird;
            bird_obj.fly(100);
        }

        if (bird instanceof Fish) {
            Fish fish_obj = (Fish) fish;
            fish_obj.swim(5.0);
        }

        if (bat instanceof Bat) {
            Bat bat_obj = (Bat) bat;
            bat_obj.fly(100);
            bat_obj.swim(5.0);
        }

        /* Downcasting the following leads to an error:
        Bird fish_obj = (Bird) fish;
        fish_obj.fly(100);

        Message:
        Exception in thread "main" java.lang.ClassCastException: class CLASS_LAB.Fish 
        cannot be cast to class CLASS_LAB.Bird (CLASS_LAB.Fish and CLASS_LAB.Bird are 
        in unnamed module of loader 'app') at CLASS_LAB.MainRun.main(MainRun.java:105)
        
        
        
        */
        
    }
}
