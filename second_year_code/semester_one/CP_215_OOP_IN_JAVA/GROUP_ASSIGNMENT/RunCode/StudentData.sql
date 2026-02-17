-- CP 215 Group Activity 2026
-- SQL setup for MySQL + JDBC demo

DROP DATABASE IF EXISTS StudentData;
CREATE DATABASE StudentData;
USE StudentData;

-- Student table
CREATE TABLE Student (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    registration_no VARCHAR(20) UNIQUE NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    degree_programme VARCHAR(100) NOT NULL,
    year_of_study INT NOT NULL,
    phone_number VARCHAR(20) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Course table
CREATE TABLE Course (
    course_id INT PRIMARY KEY AUTO_INCREMENT,
    course_code VARCHAR(20) UNIQUE NOT NULL,
    course_name VARCHAR(120) UNIQUE NOT NULL,
    degree_programme VARCHAR(100) NOT NULL,
    semester VARCHAR(20) NOT NULL,
    credits INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample students
INSERT INTO Student (registration_no, full_name, degree_programme, year_of_study, phone_number, email)
VALUES
('2026-04-0001', 'Asha Mrema', 'BSc Computer Science', 2, '+255712345001', 'asha.mrema@student.ac.tz'),
('2026-04-0002', 'Brian Kweka', 'BSc Computer Science', 2, '+255712345002', 'brian.kweka@student.ac.tz'),
('2026-04-0003', 'Clara Massawe', 'BSc Information Technology', 1, '+255712345003', 'clara.massawe@student.ac.tz');

-- Sample courses
INSERT INTO Course (course_code, course_name, degree_programme, semester, credits)
VALUES
('CP215', 'Object Oriented Programming in Java', 'BSc Computer Science', 'Semester 2', 4),
('CP216', 'Database Systems', 'BSc Computer Science', 'Semester 2', 3),
('IT210', 'Computer Networks', 'BSc Information Technology', 'Semester 2', 3);

-- Quick checks
SELECT * FROM Student;
SELECT * FROM Course;
