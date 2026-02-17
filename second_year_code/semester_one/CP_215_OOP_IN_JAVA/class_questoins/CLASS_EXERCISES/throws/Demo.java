import java.io.*;

class Demo {

    static void readFile(String fileName) throws IOException {
        FileReader file = new FileReader(fileName);
    }

    public static void main(String[] args) {
        try {
            readFile("test.txt");
        } catch (IOException e) {
            System.out.println("File not found: " + e.getMessage());
        }
    }
}
