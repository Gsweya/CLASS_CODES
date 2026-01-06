package assignments.practical_7.QuestionTwo;

abstract class Shape {

    private int dimensions;

    public void get_description() {

    }
}

class TwoDimensionalShape extends Shape {
    final int dimensions = 2;    

    public double getArea() {
        double area = 0;

        return area;
    }

    public void get_description(){
        System.out.println("This is a two dimensional shape");
    }
    
}

class ThreeDimensionalShape extends Shape {
    final int dimensions = 3;

    public void get_description(){
        System.out.println("This is a three dimensional shape");
    }

    public double getArea() {
        double area = 0;

        return area;

    }

    public double getVolume() {
        double volume = 0;

        return volume;
    }
}

class Circle extends TwoDimensionalShape {
    double radius;
    
    public Circle(double radius) {
        this.radius = radius;
    }

    @Override
    public double getArea(){
        double area;
        area = Math.PI * Math.pow(this.radius, 2);

        return area;
    }

    @Override
    public void get_description() {
        System.out.println("This is a Circle.");
        System.out.println("----------------------------------");
        // super key has been used to call the method fromteh Dimensional Class
        super.get_description();
        System.out.println("The radius of the Cricle is: " + this.radius);

        System.out.println("Area = Constant Pie * Radis^2");
        System.out.printf("Area of the Circle: %.2f\n", getArea());     
        
    }
}


class Square extends TwoDimensionalShape {
    double length;

    public Square(double length) {
        this.length = length;
    }

    @Override
    public double getArea(){
        double area;
        area = this.length * this.length;

        return area;
    }

    @Override
    public void get_description() {
        System.out.println("This is a Square.");
        System.out.println("------------------------------------------");
        // super key has been used to call the method fromteh Dimensional Class
        super.get_description();
        System.out.println("The length of the Square is: " + this.length);

        System.out.println("Area = Length * Length");
        System.out.printf("Area of the Square: %.2f\n", getArea() );

        
    }
}

class Triangle extends TwoDimensionalShape {
    double base;
    double height;

    public Triangle(double base, double height) {
        this.height = height;
        this.base = base;
    }

    @Override
    public double getArea(){
        double area;
        area = 0.5 * this.base * this.height;

        return area;
    }

    @Override
    public void get_description() {
        System.out.println("This is a Triangle.");
        System.out.println("------------------------------------");
        // super key has been used to call the method fromteh Dimensional Class
        super.get_description();
        System.out.printf("The base of the Triangle is %f and the height is \n" , base, height);

        System.out.println("Area = !/2 * Base * Height");
        System.out.printf("Area of the Triangle: %.2f\n", getArea() );     
        
    }

}


// Three dimensional Figures 

class Sphere extends ThreeDimensionalShape {
    double radius;

    public Sphere (double radius) {
        this.radius = radius;
    }

    @Override
    public double getArea() {
        double area;
        area = 4 * Math.PI * Math.pow(radius, 2);

        return area;
    }

    @Override
    public double getVolume(){
        double volume;
        volume = (4/3) * Math.PI * Math.pow(radius, 3);

        return volume;
    }

    @Override
    public void get_description() {
        System.out.println("This is a Sphere.");
        System.out.println("------------------------------------");
        // super key has been used to call the method fromteh Dimensional Class
        super.get_description();
        System.out.println("The radius of the Sphere is: " + this.radius);

        System.out.println("Volume = 4 * Pie * radius^2");
        System.out.printf("Area of the Sphere: %.2f\n", getArea());
        
        System.out.println("Volume = 4/3 * Pie * radius^3");
        System.out.printf("Volume of the Sphere: %.2f\n", getVolume());
        
    }
}

class Cube extends ThreeDimensionalShape {
    double side;

    public Cube (double side) {
        this.side = side;
    }

    @Override
    public double getArea() {
        double area;
        area = 6 * Math.pow(this.side, 2);

        return area;
    }

    @Override
    public double getVolume() {
        double volume;
        volume = Math.pow(this.side, 3);

        return volume;
    }

    @Override
    public void get_description() {
        System.out.println("This is a Cube");
        System.out.println("----------------------------");
        // super key has been used to call the method fromteh Dimensional Class
        super.get_description();
        System.out.println("The side of the Cube is: " + this.side);

        System.out.println("Area = 6 * Side^2");
        System.out.printf("Area of the Cube: %.2f\n", getArea() );
        
        System.out.println("Volume = Sides^3");
        System.out.printf("Volume of the Cube: %.2f\n", getVolume() );
        
    }
}

class Tetrahedron extends ThreeDimensionalShape {
    double edge;

    public Tetrahedron(double edge) {
        this.edge = edge;
    }

    @Override
    public double getArea(){
        double area;
        area = Math.sqrt(3) * Math.pow(edge, 2);

        return area;
    }

    @Override
    public double getVolume() {
        double volume;
        volume = (Math.pow(edge, 3)) / (6 * (Math.sqrt(2)));

        return volume;
    }

    @Override
    public void get_description() {
        System.out.println("This is a Tetrahedron");
        System.out.println("-------------------------------");
        // super key has been used to call the method from the  Dimensional Class
        super.get_description();
        System.out.println("The edge of the Tetrahedron is: " + this.edge);

        System.out.println("Area = Square root of 3 * edge^2");
        System.out.printf("Area of the Tetrahedron: %.2f\n", getArea());
        
        System.out.println("Volume = (edge^3) / (6 * square root 2)");
        System.out.printf("Volume of the Tetrahedron: %.2f\n", getVolume() );
        
    }
}




public class QuestionTwo {

    public static void main(String[] args) {

        Shape[] shapes = new Shape[6];

        // Circle 
        Circle circle_object = new Circle(4.64);
        shapes[0] = circle_object;

        // Square 
        Square square_object = new Square(5.67);
        shapes[1] = square_object;

        // Triangle 
        Triangle triangle_object = new Triangle(10.5, 13.2);
        shapes[2] = triangle_object;

        // Sphere 
        Sphere sphere_object = new Sphere(20.5);
        shapes[3] = sphere_object;

        // Cube 
        Cube cube_object = new Cube(30.5);
        shapes[4] = cube_object;

        // Tetrahedron 
        Tetrahedron tetrahedron_object = new Tetrahedron(40.5);
        shapes[5] = tetrahedron_object;



        for (int i = 0 ; i < 6; i++) {

            // Required to determine what class is the shape but can use
            // Alternative shapes[i] instanceof TwoDimensionalShape

            if (shapes[i] instanceof TwoDimensionalShape){
                System.out.println("Detected 2-Dimensional Shape:");
                System.out.println("-------------------------------");
                shapes[i].get_description();
                System.out.println("------------------------------\n\n");
            }
            else if (shapes[i] instanceof ThreeDimensionalShape) {
                System.out.println("Detected 3-Dimensional Shape:");
                System.out.println("-------------------------------");
                shapes[i].get_description();
                System.out.println("-------------------------------\n\n");
            }
            else {
                System.out.println("Invalid shape");
            }
        }
    }    
}
