interface Polygon {

    final int age = 10;

    public static void getData(){
        System.out.println("A static method inside an interface.");
        System.out.println("AGE: " + age);

    }
}



class Demo {

    static int year;

    public static void main(String[] args){

        Polygon.getData();
    }


}