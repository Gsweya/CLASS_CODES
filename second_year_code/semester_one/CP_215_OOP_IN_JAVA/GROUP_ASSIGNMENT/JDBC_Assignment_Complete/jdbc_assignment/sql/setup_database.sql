-- ============================================
-- CP 215: JDBC Assignment SQL Script
-- Database: StudentData
-- ============================================

-- Drop database if exists and create fresh
DROP DATABASE IF EXISTS StudentData;
CREATE DATABASE StudentData;
USE StudentData;

-- ============================================
-- Table: Student
-- ============================================
CREATE TABLE Student (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15),
    enrollment_date DATE NOT NULL,
    gpa DECIMAL(3,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- Table: Course
-- ============================================
CREATE TABLE Course (
    course_id INT PRIMARY KEY AUTO_INCREMENT,
    course_code VARCHAR(10) UNIQUE NOT NULL,
    course_name VARCHAR(100) NOT NULL,
    credits INT NOT NULL,
    instructor VARCHAR(100),
    semester VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ============================================
-- Table: Enrollment (Many-to-Many relationship)
-- ============================================
CREATE TABLE Enrollment (
    enrollment_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT NOT NULL,
    course_id INT NOT NULL,
    grade VARCHAR(2),
    enrollment_year INT,
    FOREIGN KEY (student_id) REFERENCES Student(student_id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES Course(course_id) ON DELETE CASCADE,
    UNIQUE KEY unique_enrollment (student_id, course_id)
);

-- ============================================
-- Sample Data Insertion
-- ============================================

-- Insert Students
INSERT INTO Student (first_name, last_name, email, phone, enrollment_date, gpa) VALUES
('John', 'Doe', 'john.doe@student.ac.tz', '+255712345678', '2024-09-01', 3.75),
('Jane', 'Smith', 'jane.smith@student.ac.tz', '+255723456789', '2024-09-01', 3.90),
('Michael', 'Johnson', 'michael.j@student.ac.tz', '+255734567890', '2024-09-01', 3.50),
('Sarah', 'Williams', 'sarah.w@student.ac.tz', '+255745678901', '2024-09-01', 3.85),
('David', 'Brown', 'david.b@student.ac.tz', '+255756789012', '2024-09-01', 3.60);

-- Insert Courses
INSERT INTO Course (course_code, course_name, credits, instructor, semester) VALUES
('CP215', 'Object Oriented Programming in Java', 4, 'Dr. Mwanga', 'Spring 2026'),
('CP201', 'Data Structures and Algorithms', 4, 'Prof. Nyerere', 'Spring 2026'),
('CP301', 'Database Management Systems', 3, 'Dr. Kikwete', 'Spring 2026'),
('CP305', 'Software Engineering', 3, 'Prof. Mkapa', 'Spring 2026'),
('CP401', 'Artificial Intelligence', 4, 'Dr. Magufuli', 'Spring 2026');

-- Insert Enrollments
INSERT INTO Enrollment (student_id, course_id, grade, enrollment_year) VALUES
(1, 1, 'A', 2026),
(1, 2, 'A-', 2026),
(2, 1, 'A+', 2026),
(2, 3, 'A', 2026),
(3, 1, 'B+', 2026),
(3, 4, 'A-', 2026),
(4, 2, 'A', 2026),
(4, 5, 'A+', 2026),
(5, 3, 'B+', 2026),
(5, 4, 'A-', 2026);

-- ============================================
-- Verification Queries
-- ============================================

-- View all students
SELECT * FROM Student;

-- View all courses
SELECT * FROM Course;

-- View enrollments with student and course details
SELECT 
    s.first_name, 
    s.last_name, 
    c.course_code, 
    c.course_name, 
    e.grade
FROM Enrollment e
JOIN Student s ON e.student_id = s.student_id
JOIN Course c ON e.course_id = c.course_id
ORDER BY s.last_name, c.course_code;

-- Count students per course
SELECT 
    c.course_code,
    c.course_name,
    COUNT(e.student_id) as total_students
FROM Course c
LEFT JOIN Enrollment e ON c.course_id = e.course_id
GROUP BY c.course_id
ORDER BY total_students DESC;
