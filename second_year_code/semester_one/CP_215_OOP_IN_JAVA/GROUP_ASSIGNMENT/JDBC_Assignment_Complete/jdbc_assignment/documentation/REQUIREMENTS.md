# JDBC Assignment - Requirements & Dependencies

## System Requirements

### Minimum Hardware Requirements
- Processor: Intel Core i3 or equivalent
- RAM: 4GB minimum (8GB recommended)
- Storage: 500MB free space
- Network: Required for remote database connections

### Operating System Support
- Windows 10/11
- macOS 10.14 or later
- Linux (Ubuntu 20.04+, Fedora, etc.)

---

## Software Requirements (Task 2)

### 1. Java Development Kit (JDK)
- **Version:** JDK 8 or higher (JDK 11+ recommended)
- **Purpose:** Compiling and running Java programs
- **Download:** https://www.oracle.com/java/technologies/downloads/
- **Alternative:** OpenJDK from https://openjdk.org/

**Installation Verification:**
```bash
java -version
javac -version
```

### 2. MySQL Database Server
- **Version:** MySQL 8.0 or higher
- **Purpose:** Database Management System
- **Download:** https://dev.mysql.com/downloads/mysql/
- **Alternative:** MariaDB 10.5+

**Installation Verification:**
```bash
mysql --version
```

### 3. MySQL JDBC Driver (Connector/J)
- **File:** mysql-connector-java-8.0.33.jar (or latest)
- **Purpose:** JDBC driver for MySQL database connectivity
- **Download:** https://dev.mysql.com/downloads/connector/j/
- **Maven Dependency:**
```xml
<dependency>
    <groupId>mysql</groupId>
    <artifactId>mysql-connector-java</artifactId>
    <version>8.0.33</version>
</dependency>
```

---

## Java Package Dependencies

### Core JDBC Packages (Built-in)
```java
java.sql.Connection          // Database connection interface
java.sql.DriverManager       // Driver management
java.sql.Statement           // SQL statement execution
java.sql.PreparedStatement   // Precompiled SQL statements
java.sql.ResultSet           // Query result storage
java.sql.SQLException        // Exception handling
java.sql.DatabaseMetaData    // Database metadata
java.sql.ResultSetMetaData   // ResultSet metadata
java.sql.Date                // SQL date handling
```

### Required JAR Files
1. **mysql-connector-java-8.0.33.jar** (or latest version)
   - Location: Project lib folder or system classpath
   - Purpose: MySQL JDBC driver implementation

---

## Installation Steps

### Step 1: Install JDK

**Windows:**
1. Download JDK installer from Oracle
2. Run installer and follow wizard
3. Set JAVA_HOME environment variable
4. Add %JAVA_HOME%\bin to PATH

**Linux (Ubuntu/Debian):**
```bash
sudo apt update
sudo apt install openjdk-11-jdk
```

**macOS:**
```bash
brew install openjdk@11
```

### Step 2: Install MySQL Server

**Windows:**
1. Download MySQL Installer
2. Choose "Developer Default" setup type
3. Set root password during installation
4. Complete configuration wizard

**Linux (Ubuntu/Debian):**
```bash
sudo apt update
sudo apt install mysql-server
sudo mysql_secure_installation
```

**macOS:**
```bash
brew install mysql
brew services start mysql
mysql_secure_installation
```

### Step 3: Download JDBC Driver

**Manual Download:**
1. Visit: https://dev.mysql.com/downloads/connector/j/
2. Select Platform Independent
3. Download ZIP archive
4. Extract mysql-connector-java-X.X.XX.jar

**Maven (if using Maven):**
Add to pom.xml:
```xml
<dependencies>
    <dependency>
        <groupId>mysql</groupId>
        <artifactId>mysql-connector-java</artifactId>
        <version>8.0.33</version>
    </dependency>
</dependencies>
```

### Step 4: Setup MySQL Database

```bash
# Login to MySQL
mysql -u root -p

# Run setup script
source /path/to/setup_database.sql

# OR manually:
CREATE DATABASE StudentData;
USE StudentData;
# ... paste SQL commands
```

---

## IDE Setup (Optional)

### IntelliJ IDEA
1. File → New → Project
2. Select Java project
3. Add MySQL Connector JAR:
   - File → Project Structure → Libraries → + → Java
   - Browse to mysql-connector-java.jar

### Eclipse
1. File → New → Java Project
2. Add MySQL Connector JAR:
   - Right-click project → Build Path → Configure Build Path
   - Libraries tab → Add External JARs
   - Browse to mysql-connector-java.jar

### NetBeans
1. File → New Project → Java Application
2. Add MySQL Connector JAR:
   - Right-click Libraries → Add JAR/Folder
   - Browse to mysql-connector-java.jar

---

## Network Configuration (For Remote Access)

### MySQL Server Configuration

**Allow Remote Connections:**

1. Edit MySQL configuration file:
```bash
# Linux
sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf

# Find and change:
bind-address = 0.0.0.0  # Allow all IPs
```

2. Create remote user:
```sql
CREATE USER 'student'@'%' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON StudentData.* TO 'student'@'%';
FLUSH PRIVILEGES;
```

3. Open firewall port:
```bash
# Linux (UFW)
sudo ufw allow 3306/tcp

# Linux (iptables)
sudo iptables -A INPUT -p tcp --dport 3306 -j ACCEPT
```

### Client Configuration

Update `DatabaseConfig.java`:
```java
private static final String REMOTE_URL = "jdbc:mysql://SERVER_IP:3306/StudentData";
private boolean useRemoteConnection = true;
```

---

## Environment Variables

### Windows
```batch
set JAVA_HOME=C:\Program Files\Java\jdk-11
set PATH=%PATH%;%JAVA_HOME%\bin
set CLASSPATH=.;C:\path\to\mysql-connector-java.jar
```

### Linux/macOS
```bash
export JAVA_HOME=/usr/lib/jvm/java-11-openjdk
export PATH=$PATH:$JAVA_HOME/bin
export CLASSPATH=.:path/to/mysql-connector-java.jar
```

---

## Classpath Configuration

### Compile Time
```bash
javac -cp .:mysql-connector-java-8.0.33.jar *.java
```

### Runtime
```bash
java -cp .:mysql-connector-java-8.0.33.jar:. com.cp215.jdbc.JDBCAssignment
```

### Windows (use semicolon)
```batch
javac -cp .;mysql-connector-java-8.0.33.jar *.java
java -cp .;mysql-connector-java-8.0.33.jar;. com.cp215.jdbc.JDBCAssignment
```

---

## Verification Checklist

- [ ] JDK installed and java/javac commands work
- [ ] MySQL Server installed and running
- [ ] MySQL root password set
- [ ] MySQL Connector/J JAR downloaded
- [ ] Database "StudentData" created
- [ ] Tables created successfully
- [ ] Sample data inserted
- [ ] JDBC driver JAR in classpath
- [ ] DatabaseConfig.java updated with credentials
- [ ] Test connection successful

---

## Common Issues & Solutions

### Issue 1: ClassNotFoundException
**Error:** `java.lang.ClassNotFoundException: com.mysql.cj.jdbc.Driver`

**Solution:**
- Ensure MySQL Connector JAR is in classpath
- Verify JAR file path is correct
- Check classpath syntax (: for Unix, ; for Windows)

### Issue 2: Access Denied
**Error:** `Access denied for user 'root'@'localhost'`

**Solution:**
- Verify username/password in DatabaseConfig.java
- Reset MySQL root password if needed
- Check user privileges

### Issue 3: Connection Refused
**Error:** `Communications link failure`

**Solution:**
- Verify MySQL service is running
- Check port 3306 is open
- Verify firewall settings
- For remote: Check bind-address in my.cnf

### Issue 4: Database Not Found
**Error:** `Unknown database 'StudentData'`

**Solution:**
- Run setup_database.sql script
- Verify database creation: `SHOW DATABASES;`
- Check database name spelling

---

## Additional Tools (Optional)

### MySQL Workbench
- GUI tool for database management
- Download: https://dev.mysql.com/downloads/workbench/

### DBeaver
- Universal database tool
- Download: https://dbeaver.io/

### phpMyAdmin
- Web-based MySQL management
- Useful for remote server management

---

## Documentation Resources

1. **Oracle JDBC Tutorial:**
   https://docs.oracle.com/javase/tutorial/jdbc/

2. **MySQL Connector/J Developer Guide:**
   https://dev.mysql.com/doc/connector-j/en/

3. **Java SQL Package API:**
   https://docs.oracle.com/javase/8/docs/api/java/sql/package-summary.html

4. **MySQL Reference Manual:**
   https://dev.mysql.com/doc/refman/8.0/en/

---

**Last Updated:** February 2026  
**Compatible With:** MySQL 8.0+, JDK 8+
