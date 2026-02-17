import java.sql.*;

public class MainApp {

    static final String DB_URL = "jdbc:mysql://127.0.0.1/test_db";
    static final String USER = "root";
    static final String PASS = "-----";
    static final String QUERY =
        "Select id, age, first_name, last_name FROM employees";

    public static void main(String[] args) {
        // Open a connection
        try (
            Connection conn = DriverManager.getConnection(DB_URL, USER, PASS);
            Statement stmt = conn.createStatement();
            ResultSet rs = stmt.executeQuery(QUERY);
        ) {
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
