package com.cp215.jdbc.config;

/**
 * CP 215: Database Configuration Class
 * Manages database connection parameters
 */
public class DatabaseConfig {
    
    // Database connection parameters
    // For local connection
    private static final String LOCAL_URL = "jdbc:mysql://localhost:3306/StudentData";
    
    // For remote connection (example IP)
    // Replace with actual remote server IP address
    private static final String REMOTE_URL = "jdbc:mysql://192.168.1.100:3306/StudentData";
    
    // Database credentials
    private static final String USERNAME = "root";
    private static final String PASSWORD = "your_password_here";
    
    // JDBC Driver
    private static final String DRIVER = "com.mysql.cj.jdbc.Driver";
    
    // Connection timeout settings
    private static final String CONNECTION_OPTIONS = 
        "?useSSL=false&serverTimezone=UTC&allowPublicKeyRetrieval=true";
    
    /**
     * Get database URL (local by default)
     * @param useRemote true to use remote connection, false for local
     * @return database URL string
     */
    public static String getUrl(boolean useRemote) {
        return (useRemote ? REMOTE_URL : LOCAL_URL) + CONNECTION_OPTIONS;
    }
    
    /**
     * Get database username
     * @return username
     */
    public static String getUsername() {
        return USERNAME;
    }
    
    /**
     * Get database password
     * @return password
     */
    public static String getPassword() {
        return PASSWORD;
    }
    
    /**
     * Get JDBC driver class name
     * @return driver class name
     */
    public static String getDriver() {
        return DRIVER;
    }
    
    /**
     * Display connection information (without password)
     */
    public static void displayConfig(boolean useRemote) {
        System.out.println("=== Database Configuration ===");
        System.out.println("URL: " + getUrl(useRemote));
        System.out.println("Username: " + USERNAME);
        System.out.println("Driver: " + DRIVER);
        System.out.println("==============================");
    }
}
