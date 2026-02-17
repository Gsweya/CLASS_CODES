package com.cp215.jdbc;

import com.cp215.jdbc.config.DatabaseConfig;
import java.sql.*;
import java.util.Scanner;

/**
 * CP 215: Complete JDBC Assignment Implementation
 * Demonstrates all required JDBC operations:
 * - Loading drivers
 * - Establishing connections
 * - Creating statements
 * - Executing queries
 * - Processing ResultSets
 * - Using PreparedStatements
 * - Batch operations
 * - Exception handling
 */
public class JDBCAssignment {
    
    private Connection connection;
    private boolean useRemoteConnection = false;
    
    /**
     * Constructor - establishes database connection
     */
    public JDBCAssignment() {
        try {
            // STEP 1: Load JDBC Driver
            loadDriver();
            
            // STEP 2: Establish Connection
            establishConnection();
            
            System.out.println("✓ Database connection established successfully!\n");
            
        } catch (Exception e) {
            System.err.println("ERROR: Failed to initialize database connection");
            e.printStackTrace();
        }
    }
    
    /**
     * STEP 1: Load the JDBC Driver
     * This registers the driver with DriverManager
     */
    private void loadDriver() throws ClassNotFoundException {
        System.out.println("STEP 1: Loading JDBC Driver...");
        Class.forName(DatabaseConfig.getDriver());
        System.out.println("✓ Driver loaded: " + DatabaseConfig.getDriver());
    }
    
    /**
     * STEP 2: Establish Database Connection
     * Creates connection to MySQL database
     */
    private void establishConnection() throws SQLException {
        System.out.println("\nSTEP 2: Establishing Connection...");
        DatabaseConfig.displayConfig(useRemoteConnection);
        
        connection = DriverManager.getConnection(
            DatabaseConfig.getUrl(useRemoteConnection),
            DatabaseConfig.getUsername(),
            DatabaseConfig.getPassword()
        );
        
        // Disable auto-commit for transaction control
        connection.setAutoCommit(true);
        System.out.println("✓ Connection established");
    }
    
    /**
     * STEP 3 & 4: Create Statement and Execute Query
     * Demonstrates basic Statement usage
     */
    public void demonstrateStatement() {
        System.out.println("\n=== DEMONSTRATION: Statement ===");
        Statement stmt = null;
        ResultSet rs = null;
        
        try {
            // STEP 3: Create Statement
            stmt = connection.createStatement();
            System.out.println("✓ Statement created");
            
            // STEP 4: Execute Query
            String query = "SELECT * FROM Student";
            System.out.println("Executing: " + query);
            rs = stmt.executeQuery(query);
            
            // STEP 5: Process ResultSet
            processStudentResultSet(rs);
            
        } catch (SQLException e) {
            System.err.println("ERROR: Statement execution failed");
            e.printStackTrace();
        } finally {
            // STEP 6: Close resources
            closeResources(rs, stmt);
        }
    }
    
    /**
     * Process and display ResultSet data
     */
    private void processStudentResultSet(ResultSet rs) throws SQLException {
        System.out.println("\n--- Students in Database ---");
        System.out.printf("%-5s %-15s %-15s %-30s %-6s%n",
            "ID", "First Name", "Last Name", "Email", "GPA");
        System.out.println("-".repeat(75));
        
        while (rs.next()) {
            int id = rs.getInt("student_id");
            String firstName = rs.getString("first_name");
            String lastName = rs.getString("last_name");
            String email = rs.getString("email");
            double gpa = rs.getDouble("gpa");
            
            System.out.printf("%-5d %-15s %-15s %-30s %.2f%n",
                id, firstName, lastName, email, gpa);
        }
    }
    
    /**
     * INSERT operation using PreparedStatement
     */
    public void insertStudentWithPreparedStatement(String firstName, String lastName, 
            String email, String phone, String enrollmentDate, double gpa) {
        
        System.out.println("\n=== INSERT with PreparedStatement ===");
        String sql = "INSERT INTO Student (first_name, last_name, email, phone, " +
                     "enrollment_date, gpa) VALUES (?, ?, ?, ?, ?, ?)";
        
        try (PreparedStatement pstmt = connection.prepareStatement(sql, 
                Statement.RETURN_GENERATED_KEYS)) {
            
            // Set parameters
            pstmt.setString(1, firstName);
            pstmt.setString(2, lastName);
            pstmt.setString(3, email);
            pstmt.setString(4, phone);
            pstmt.setDate(5, Date.valueOf(enrollmentDate));
            pstmt.setDouble(6, gpa);
            
            // Execute update
            int rowsAffected = pstmt.executeUpdate();
            System.out.println("✓ " + rowsAffected + " row(s) inserted");
            
            // Get generated key
            ResultSet generatedKeys = pstmt.getGeneratedKeys();
            if (generatedKeys.next()) {
                System.out.println("✓ Generated Student ID: " + generatedKeys.getInt(1));
            }
            
        } catch (SQLException e) {
            System.err.println("ERROR: Insert failed");
            e.printStackTrace();
        }
    }
    
    /**
     * SELECT operation using PreparedStatement
     */
    public void selectStudentByEmail(String email) {
        System.out.println("\n=== SELECT with PreparedStatement ===");
        String sql = "SELECT * FROM Student WHERE email = ?";
        
        try (PreparedStatement pstmt = connection.prepareStatement(sql)) {
            
            pstmt.setString(1, email);
            ResultSet rs = pstmt.executeQuery();
            
            if (rs.next()) {
                System.out.println("Student Found:");
                System.out.println("  ID: " + rs.getInt("student_id"));
                System.out.println("  Name: " + rs.getString("first_name") + 
                                   " " + rs.getString("last_name"));
                System.out.println("  Email: " + rs.getString("email"));
                System.out.println("  GPA: " + rs.getDouble("gpa"));
            } else {
                System.out.println("No student found with email: " + email);
            }
            
            rs.close();
            
        } catch (SQLException e) {
            System.err.println("ERROR: Select failed");
            e.printStackTrace();
        }
    }
    
    /**
     * UPDATE operation using PreparedStatement
     */
    public void updateStudentGPA(int studentId, double newGPA) {
        System.out.println("\n=== UPDATE with PreparedStatement ===");
        String sql = "UPDATE Student SET gpa = ? WHERE student_id = ?";
        
        try (PreparedStatement pstmt = connection.prepareStatement(sql)) {
            
            pstmt.setDouble(1, newGPA);
            pstmt.setInt(2, studentId);
            
            int rowsAffected = pstmt.executeUpdate();
            
            if (rowsAffected > 0) {
                System.out.println("✓ Student ID " + studentId + 
                                   " GPA updated to " + newGPA);
            } else {
                System.out.println("No student found with ID: " + studentId);
            }
            
        } catch (SQLException e) {
            System.err.println("ERROR: Update failed");
            e.printStackTrace();
        }
    }
    
    /**
     * DELETE operation using PreparedStatement
     */
    public void deleteStudentById(int studentId) {
        System.out.println("\n=== DELETE with PreparedStatement ===");
        String sql = "DELETE FROM Student WHERE student_id = ?";
        
        try (PreparedStatement pstmt = connection.prepareStatement(sql)) {
            
            pstmt.setInt(1, studentId);
            
            int rowsAffected = pstmt.executeUpdate();
            
            if (rowsAffected > 0) {
                System.out.println("✓ Student ID " + studentId + " deleted");
            } else {
                System.out.println("No student found with ID: " + studentId);
            }
            
        } catch (SQLException e) {
            System.err.println("ERROR: Delete failed");
            e.printStackTrace();
        }
    }
    
    /**
     * BATCH INSERT - Insert multiple students efficiently
     */
    public void batchInsertStudents() {
        System.out.println("\n=== BATCH INSERT Operation ===");
        String sql = "INSERT INTO Student (first_name, last_name, email, phone, " +
                     "enrollment_date, gpa) VALUES (?, ?, ?, ?, ?, ?)";
        
        try (PreparedStatement pstmt = connection.prepareStatement(sql)) {
            
            // Disable auto-commit for batch
            connection.setAutoCommit(false);
            
            // Student 1
            pstmt.setString(1, "Alice");
            pstmt.setString(2, "Cooper");
            pstmt.setString(3, "alice.c@student.ac.tz");
            pstmt.setString(4, "+255767890123");
            pstmt.setDate(5, Date.valueOf("2024-09-01"));
            pstmt.setDouble(6, 3.70);
            pstmt.addBatch();
            
            // Student 2
            pstmt.setString(1, "Bob");
            pstmt.setString(2, "Martin");
            pstmt.setString(3, "bob.m@student.ac.tz");
            pstmt.setString(4, "+255778901234");
            pstmt.setDate(5, Date.valueOf("2024-09-01"));
            pstmt.setDouble(6, 3.55);
            pstmt.addBatch();
            
            // Student 3
            pstmt.setString(1, "Carol");
            pstmt.setString(2, "Davis");
            pstmt.setString(3, "carol.d@student.ac.tz");
            pstmt.setString(4, "+255789012345");
            pstmt.setDate(5, Date.valueOf("2024-09-01"));
            pstmt.setDouble(6, 3.95);
            pstmt.addBatch();
            
            // Execute batch
            int[] results = pstmt.executeBatch();
            connection.commit();
            
            System.out.println("✓ Batch insert completed: " + results.length + 
                               " students inserted");
            
            // Re-enable auto-commit
            connection.setAutoCommit(true);
            
        } catch (SQLException e) {
            try {
                connection.rollback();
                System.err.println("ERROR: Batch insert failed - rolled back");
            } catch (SQLException ex) {
                ex.printStackTrace();
            }
            e.printStackTrace();
        }
    }
    
    /**
     * BATCH UPDATE - Update multiple records efficiently
     */
    public void batchUpdateGPAs() {
        System.out.println("\n=== BATCH UPDATE Operation ===");
        String sql = "UPDATE Student SET gpa = ? WHERE student_id = ?";
        
        try (PreparedStatement pstmt = connection.prepareStatement(sql)) {
            
            connection.setAutoCommit(false);
            
            // Update student 1
            pstmt.setDouble(1, 3.80);
            pstmt.setInt(2, 1);
            pstmt.addBatch();
            
            // Update student 2
            pstmt.setDouble(1, 3.95);
            pstmt.setInt(2, 2);
            pstmt.addBatch();
            
            // Update student 3
            pstmt.setDouble(1, 3.65);
            pstmt.setInt(2, 3);
            pstmt.addBatch();
            
            // Execute batch
            int[] results = pstmt.executeBatch();
            connection.commit();
            
            System.out.println("✓ Batch update completed: " + results.length + 
                               " students updated");
            
            connection.setAutoCommit(true);
            
        } catch (SQLException e) {
            try {
                connection.rollback();
                System.err.println("ERROR: Batch update failed - rolled back");
            } catch (SQLException ex) {
                ex.printStackTrace();
            }
            e.printStackTrace();
        }
    }
    
    /**
     * Dynamic multiple row insertion using loop
     */
    public void dynamicMultipleInsert(int numberOfStudents) {
        System.out.println("\n=== DYNAMIC MULTIPLE INSERT ===");
        String sql = "INSERT INTO Student (first_name, last_name, email, phone, " +
                     "enrollment_date, gpa) VALUES (?, ?, ?, ?, ?, ?)";
        
        try (PreparedStatement pstmt = connection.prepareStatement(sql)) {
            
            connection.setAutoCommit(false);
            
            for (int i = 1; i <= numberOfStudents; i++) {
                pstmt.setString(1, "Student" + i);
                pstmt.setString(2, "Batch" + i);
                pstmt.setString(3, "student" + i + "@batch.ac.tz");
                pstmt.setString(4, "+25578000000" + i);
                pstmt.setDate(5, Date.valueOf("2024-09-01"));
                pstmt.setDouble(6, 3.00 + (Math.random() * 1.0)); // Random GPA
                pstmt.addBatch();
            }
            
            int[] results = pstmt.executeBatch();
            connection.commit();
            
            System.out.println("✓ Dynamically inserted " + results.length + " students");
            
            connection.setAutoCommit(true);
            
        } catch (SQLException e) {
            try {
                connection.rollback();
                System.err.println("ERROR: Dynamic insert failed - rolled back");
            } catch (SQLException ex) {
                ex.printStackTrace();
            }
            e.printStackTrace();
        }
    }
    
    /**
     * Demonstrate DatabaseMetaData
     */
    public void exploreDatabaseMetadata() {
        System.out.println("\n=== DATABASE METADATA ===");
        
        try {
            DatabaseMetaData dbMetaData = connection.getMetaData();
            
            System.out.println("Database Product: " + dbMetaData.getDatabaseProductName());
            System.out.println("Database Version: " + dbMetaData.getDatabaseProductVersion());
            System.out.println("Driver Name: " + dbMetaData.getDriverName());
            System.out.println("Driver Version: " + dbMetaData.getDriverVersion());
            System.out.println("URL: " + dbMetaData.getURL());
            System.out.println("Username: " + dbMetaData.getUserName());
            
            System.out.println("\n--- Tables in Database ---");
            ResultSet tables = dbMetaData.getTables(null, null, "%", new String[]{"TABLE"});
            while (tables.next()) {
                System.out.println("  • " + tables.getString("TABLE_NAME"));
            }
            tables.close();
            
        } catch (SQLException e) {
            System.err.println("ERROR: Failed to retrieve metadata");
            e.printStackTrace();
        }
    }
    
    /**
     * Demonstrate ResultSetMetaData
     */
    public void exploreResultSetMetadata() {
        System.out.println("\n=== RESULTSET METADATA ===");
        
        try (Statement stmt = connection.createStatement();
             ResultSet rs = stmt.executeQuery("SELECT * FROM Student LIMIT 1")) {
            
            ResultSetMetaData rsMetaData = rs.getMetaData();
            int columnCount = rsMetaData.getColumnCount();
            
            System.out.println("Number of columns: " + columnCount);
            System.out.println("\n--- Column Details ---");
            
            for (int i = 1; i <= columnCount; i++) {
                System.out.println("Column " + i + ":");
                System.out.println("  Name: " + rsMetaData.getColumnName(i));
                System.out.println("  Type: " + rsMetaData.getColumnTypeName(i));
                System.out.println("  Size: " + rsMetaData.getColumnDisplaySize(i));
                System.out.println("  Nullable: " + 
                    (rsMetaData.isNullable(i) == ResultSetMetaData.columnNullable 
                        ? "Yes" : "No"));
                System.out.println();
            }
            
        } catch (SQLException e) {
            System.err.println("ERROR: Failed to retrieve ResultSet metadata");
            e.printStackTrace();
        }
    }
    
    /**
     * Display all courses
     */
    public void displayAllCourses() {
        System.out.println("\n=== ALL COURSES ===");
        String sql = "SELECT * FROM Course";
        
        try (Statement stmt = connection.createStatement();
             ResultSet rs = stmt.executeQuery(sql)) {
            
            System.out.printf("%-5s %-12s %-40s %-8s %-20s%n",
                "ID", "Code", "Name", "Credits", "Instructor");
            System.out.println("-".repeat(90));
            
            while (rs.next()) {
                System.out.printf("%-5d %-12s %-40s %-8d %-20s%n",
                    rs.getInt("course_id"),
                    rs.getString("course_code"),
                    rs.getString("course_name"),
                    rs.getInt("credits"),
                    rs.getString("instructor"));
            }
            
        } catch (SQLException e) {
            System.err.println("ERROR: Failed to retrieve courses");
            e.printStackTrace();
        }
    }
    
    /**
     * Close database resources safely
     */
    private void closeResources(ResultSet rs, Statement stmt) {
        try {
            if (rs != null) rs.close();
            if (stmt != null) stmt.close();
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }
    
    /**
     * Close database connection
     */
    public void closeConnection() {
        try {
            if (connection != null && !connection.isClosed()) {
                connection.close();
                System.out.println("\n✓ Database connection closed");
            }
        } catch (SQLException e) {
            System.err.println("ERROR: Failed to close connection");
            e.printStackTrace();
        }
    }
    
    /**
     * Main method - Demonstrates all JDBC operations
     */
    public static void main(String[] args) {
        System.out.println("╔═══════════════════════════════════════════════════╗");
        System.out.println("║   CP 215: JDBC Assignment - Complete Demo        ║");
        System.out.println("║   Object Oriented Programming in Java            ║");
        System.out.println("╚═══════════════════════════════════════════════════╝\n");
        
        JDBCAssignment jdbc = new JDBCAssignment();
        
        try {
            // Task 3: Demonstrate Statement usage
            jdbc.demonstrateStatement();
            
            // Task 5: Display courses
            jdbc.displayAllCourses();
            
            // Task 6: PreparedStatement operations
            jdbc.insertStudentWithPreparedStatement(
                "Emma", "Watson", "emma.w@student.ac.tz", 
                "+255790123456", "2024-09-01", 3.88
            );
            
            jdbc.selectStudentByEmail("john.doe@student.ac.tz");
            jdbc.updateStudentGPA(1, 3.82);
            
            // Task 7: Batch operations
            jdbc.batchInsertStudents();
            jdbc.batchUpdateGPAs();
            jdbc.dynamicMultipleInsert(5);
            
            // Task 4: Metadata exploration
            jdbc.exploreDatabaseMetadata();
            jdbc.exploreResultSetMetadata();
            
            // Display final results
            System.out.println("\n" + "=".repeat(60));
            System.out.println("Final Student List:");
            System.out.println("=".repeat(60));
            jdbc.demonstrateStatement();
            
        } catch (Exception e) {
            System.err.println("FATAL ERROR: Application failed");
            e.printStackTrace();
        } finally {
            // Task 3: Close connection
            jdbc.closeConnection();
        }
        
        System.out.println("\n✓ All JDBC operations completed successfully!");
    }
}
