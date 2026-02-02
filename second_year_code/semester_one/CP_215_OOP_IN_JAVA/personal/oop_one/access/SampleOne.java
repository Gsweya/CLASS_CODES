package access;

// for private classes or access methods to variables,
// we can only access or change them using seters and getters...

class Data {

    private String name;

    // gettter method
    public String getName() {
        return this.name;
    }

    // setter method
    public void setName(String name) {
        this.name = name;
    }
}

public class SampleOne {

    public static void main(String[] args) {
        Data d = new Data();

        // access the private variable usign the getter and setter
        d.setName("Programiz");
        System.out.println(d.getName());
    }
}
