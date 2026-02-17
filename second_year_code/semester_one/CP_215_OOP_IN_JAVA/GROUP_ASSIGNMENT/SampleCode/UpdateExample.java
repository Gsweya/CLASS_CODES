import java.sql.*;

public class UpdateExample {

    static final String DB_URL = "jdbc:mysql://127.0.0.1/test_db";
    static final String USER = "root";
    static final String PASS = "------";
    static final String QUERY1 = "UPDATE employees SET age=100 where id=3";
    static final String QUERY2 =
        "SELECT id, first_name, last_name, age FROM employees";

    public static void main(String[] args) {
        // Open a connection

        try (
            Connection conn = DriverManager.getConnection(DB_URL, USER, PASS);
            Statement stmt = conn.createStatement();
        ) {
            stmt.executeUpdate(QUERY1);
            ResultSet rs = stmt.executeQuery(QUERY2);

            // EXtract data from result set
            while (rs.next()) {
                // Retrieve by column name
                System.out.print("ID: " + rs.getInt("id"));
                System.out.print(", Age: " + rs.getInt("age"));
                System.out.print(", First: " + rs.getString("first_name"));
                System.out.println(", Last: " + rs.getString("last_name"));
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }
}
