import java.sql.*;

public class DeleteExample {

    static final String DB_URL = "jdbc:mysql://127.0.0.1/test_db";
    static final String USER = "root";
    static final String PASS = "-------";
    static final String QUERY1 = "DELETE from employees where id=1";
    static final String QUERY2 = "SELECT * from employees";

    public static void main(String[] args) {
        // Open a connection
        try (
            Connection conn = DriverManager.getConnection(DB_URL, USER, PASS);
            Statement stmt = conn.createStatement();
        ) {
            stmt.executeUpdate(QUERY1);
            ResultSet rs = stmt.executeQuery(QUERY2);
            // Extract data from result set
            while (rs.next()) {
                // Retrieve by column name
                System.out.print("ID: " + rs.getInt("id"));
                System.out.print(", Age: " + rs.getInt("age"));
                System.out.print(", First Name: " + rs.getString("first_name"));
                System.out.println(", Last Name: " + rs.getString("last_name"));
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }
}
