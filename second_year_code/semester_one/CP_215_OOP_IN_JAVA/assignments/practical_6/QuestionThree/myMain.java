package assignments.practical_6.QuestionThree;

class Polygon {

    float height, width;

    public void setValues(float height, float width){
        this.height = height;
        this.width = width;
    }

}

class Rectangle extends Polygon {
    

    public float area(){
        float area;
        area = super.height * super.width;
        
        return area;

    }
}

public class myMain {    
    public static void main(String[] args){

        Rectangle rectangle_one = new Rectangle();
        rectangle_one.setValues(5, 20);

        System.out.println("Area of the Rectangle: " + rectangle_one.area());
    

    }
    
}
