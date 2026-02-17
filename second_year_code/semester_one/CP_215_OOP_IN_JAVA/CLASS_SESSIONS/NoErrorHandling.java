class NoErrorHandling {

    public static void main(String[] args) {
        int a = 7;
        int b = 0;

        try {
            int c = a / b;
        }    catch (ArithmeticException e) {
            System.out.println("b is 0.")
        }

        catch (ClassCastException e){
            System.out.prinln("devcode");
        }
    }
}
