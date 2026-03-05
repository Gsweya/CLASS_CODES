public class test {

    public static void main(String[] args) {
        int arr[] = new int[5];
        

    try {
    
        System.out.println(arr[10]);
    
    } catch (ClassCastException e) {
    
    // Code to handle the exception
    
    } catch(RuntimeException e){
    
        System.out.println("Error handled by RunTime Exception.");
    
    }catch(Exception e){
        
        System.out.println("Errror handled by Exception.");
     // Code to handle the another exception
    }

    }
}
