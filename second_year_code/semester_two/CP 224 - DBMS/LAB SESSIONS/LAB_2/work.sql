CREATE DATABASE UniversityDB;
USE UniversityDB;


CREATE TABLE Departments (
    DepartmentID INT PRIMARY KEY AUTO_INCREMENT,
    DepartmentName VARCHAR(30) NOT NULL UNIQUE
);

-- Insert sample African university departments
INSERT INTO Departments (DepartmentName) VALUES
('Computer Science'),
('African Studies'),
('Development Economics'),
('Swahili Literature'),
('Civil Engineering'),
('Agricultural Sciences'),
('Public Health'),
('Mining Engineering');


CREATE TABLE Courses (
    CourseID INT PRIMARY KEY AUTO_INCREMENT,
    CourseName VARCHAR(100) NOT NULL UNIQUE,
    DepartmentID INT,
    FOREIGN KEY (DepartmentID) REFERENCES Departments(DepartmentID)
);

-- Insert sample courses linked to specific DepartmentIDs (1 to 8)
INSERT INTO Courses (CourseName, DepartmentID) VALUES
('Introduction to Python Programming', 1),   -- Computer Science (ID 1)
('Database Management Systems', 1),          -- Computer Science (ID 1)
('History of the Pan-African Movement', 2),   -- African Studies (ID 2)
('Post-Colonial African Literature', 2),     -- African Studies (ID 2)
('Macroeconomics in Emerging Markets', 3),   -- Development Economics (ID 3)
('Advanced Swahili Grammar', 4),             -- Swahili Literature (ID 4)
('Structural Analysis & Design', 5),         -- Civil Engineering (ID 5)
('Sustainable Irrigation Systems', 6),       -- Agricultural Sciences (ID 6)
('Epidemiology and Disease Control', 7),     -- Public Health (ID 7)
('Sub-Saharan Mineral Extraction', 8);       -- Mining Engineering (ID 8)





CREATE TABLE students (
    Studentid INT PRIMARY KEY AUTO_INCREMENT,
    FirstName VARCHAR(50) NOT NULL,
    LastName VARCHAR(50) NOT NULL,
    Gender VARCHAR(10),
    Email VARCHAR(20) UNIQUE,
    Phone  VARCHAR(20)
);


-- Insert sample African student records
INSERT INTO students (FirstName, LastName, Gender, Email, Phone) VALUES
('Kwame', 'Mensah', 'Male', 'kwame.m@email.com', '+233241234567'),       -- Ghana (West Africa)
('Amara', 'Okonkwo', 'Female', 'amara.o@email.com', '+234803123456'),     -- Nigeria (West Africa)
('Tendai', 'Moyo', 'Male', 'tendai.m@email.com', '+263771234567'),        -- Zimbabwe (Southern Africa)
('Zola', 'Dlamini', 'Female', 'zola.d@email.com', '+27821234567'),        -- South Africa (Southern Africa)
('Kofi', 'Diallo', 'Male', 'kofi.d@email.com', '+221771234567'),          -- Senegal/Guinea (West Africa)
('Nia', 'Kamau', 'Female', 'nia.k@email.com', '+254712345678'),           -- Kenya (East Africa)
('Lwazi', 'Ndiaye', 'Male', 'lwazi.n@email.com', '+221701234567'),         -- Senegal/South Africa mix
('Chidi', 'Eze', 'Male', 'chidi.e@email.com', '+234812123456'),            -- Nigeria (West Africa)
('Amina', 'Abdi', 'Female', 'amina.a@email.com', '+252611234567'),         -- Somalia/East Africa
('Tariro', 'Sibanda', 'Female', 'tariro.s@email.com', '+263711234567');    -- Zimbabwe (Southern Africa)



CREATE TABLE Registration (
    RegistrationID INT PRIMARY KEY AUTO_INCREMENT,
    StudentID INT,
    CourseID INT,
    Semester VARCHAR(20),
    Year INT,
    FOREIGN KEY (StudentID) REFERENCES students(studentid),
    FOREIGN KEY (CourseID) REFERENCES Courses(CourseID)
);

/* Check  on how to insert values to the Registration Table... consider
the foreign tables that it depends on for keys..... */

-- ============================================================================
-- UNIVERSITY DATABASE JOIN COMMANDS DEMO
-- ============================================================================

-- ----------------------------------------------------------------------------
-- COMBINATION 1: THE FULL OVERVIEW (All 4 Tables)
-- Shows: Student Name, Registered Course, Department, and Semester details.
-- Type: INNER JOIN (Only returns active student registrations)
-- ----------------------------------------------------------------------------
SELECT
    s.Studentid,
    CONCAT(s.FirstName, ' ', s.LastName) AS StudentName,
    c.CourseName,
    d.DepartmentName,
    r.Semester,
    r.Year
FROM Registration r
INNER JOIN students s ON r.StudentID = s.Studentid
INNER JOIN Courses c ON r.CourseID = c.CourseID
INNER JOIN Departments d ON c.DepartmentID = d.DepartmentID;


-- ----------------------------------------------------------------------------
-- COMBINATION 2: DEPARTMENT CATALOG (2 Tables)
-- Shows: All courses grouped and organized by their managing department.
-- Type: INNER JOIN
-- ----------------------------------------------------------------------------
SELECT
    d.DepartmentID,
    d.DepartmentName,
    c.CourseID,
    c.CourseName
FROM Departments d
INNER JOIN Courses c ON d.DepartmentID = c.DepartmentID
ORDER BY d.DepartmentName;


-- ----------------------------------------------------------------------------
-- COMBINATION 3: QUICK ROSTER (3 Tables)
-- Shows: Just the students and the raw list of classes they attend.
-- Type: INNER JOIN
-- ----------------------------------------------------------------------------
SELECT
    s.Studentid,
    s.FirstName,
    s.LastName,
    c.CourseName
FROM Registration r
INNER JOIN students s ON r.StudentID = s.Studentid
INNER JOIN Courses c ON r.CourseID = c.CourseID;


-- ----------------------------------------------------------------------------
-- COMBINATION 4: COMPREHENSIVE AUDIT (3 Tables)
-- Shows: EVERY course in the system, even if no students are registered for it.
-- Type: LEFT JOIN (Unregistered courses will show NULL for student names)
-- ----------------------------------------------------------------------------
SELECT
    c.CourseName,
    s.FirstName AS EnrolledStudentFirst,
    s.LastName AS EnrolledStudentLast
FROM Courses c
LEFT JOIN Registration r ON c.CourseID = r.CourseID
LEFT JOIN students s ON r.StudentID = s.Studentid;


-- ----------------------------------------------------------------------------
-- BONUS COMBINATION: HEADCOUNT SUMMARY (3 Tables with Aggregation)
-- Shows: Total number of African students sitting in each course.
-- Type: LEFT JOIN + GROUP BY
-- ----------------------------------------------------------------------------
SELECT
    c.CourseID,
    c.CourseName,
    COUNT(r.RegistrationID) AS TotalEnrolledStudents
FROM Courses c
LEFT JOIN Registration r ON c.CourseID = r.CourseID
GROUP BY c.CourseID, c.CourseName
ORDER BY TotalEnrolledStudents DESC;
SELECT Course.depart_id,


-- QUERIES AND FILTERING
-- ============================================================================
-- UNIVERSITY DATABASE FILTERING & SEARCH QUERIES
-- ============================================================================

-- ----------------------------------------------------------------------------
-- 1. EXACT MATCH FILTERING
-- Target: Find the complete schedule for one specific student (Kwame Mensah).
-- ----------------------------------------------------------------------------
SELECT
    s.FirstName,
    s.LastName,
    c.CourseName,
    r.Semester
FROM Registration r
INNER JOIN students s ON r.StudentID = s.Studentid
INNER JOIN Courses c ON r.CourseID = c.CourseID
WHERE s.FirstName = 'Kwame' AND s.LastName = 'Mensah';


-- ----------------------------------------------------------------------------
-- 2. FUZZY SEARCH / PATTERN MATCHING (LIKE)
-- Target: Find all courses related to 'African' topics or 'Programming'.
-- Note: % acts as a wildcard matching any characters before or after.
-- ----------------------------------------------------------------------------
SELECT CourseID, CourseName
FROM Courses
WHERE CourseName LIKE '%African%' OR CourseName LIKE '%Programming%';


-- ----------------------------------------------------------------------------
-- 3. FILTERING BY GENDER AND REGION (Using Phone Country Codes)
-- Target: Find all Female students from West Africa (Nigeria +234 / Ghana +233).
-- ----------------------------------------------------------------------------
SELECT FirstName, LastName, Gender, Phone
FROM students
WHERE Gender = 'Female'
  AND (Phone LIKE '+234%' OR Phone LIKE '+233%');


-- ----------------------------------------------------------------------------
-- 4. EMPTY/NULL DATA FILTERING
-- Target: Find departments that currently have NO courses assigned to them.
-- ----------------------------------------------------------------------------
SELECT
    d.DepartmentName,
    c.CourseName
FROM Departments d
LEFT JOIN Courses c ON d.DepartmentID = c.DepartmentID
WHERE c.CourseID IS NULL;


-- ----------------------------------------------------------------------------
-- 5. AGGREGATE FILTERING (HAVING Clause)
-- Target: Identify crowded classes that have more than 1 student registered.
-- Note: Use WHERE to filter rows BEFORE grouping; use HAVING to filter AFTER grouping.
-- ----------------------------------------------------------------------------
SELECT
    c.CourseName,
    COUNT(r.RegistrationID) AS TotalStudents
FROM Courses c
INNER JOIN Registration r ON c.CourseID = r.CourseID
GROUP BY c.CourseID, c.CourseName
HAVING TotalStudents > 1;


-- ----------------------------------------------------------------------------
-- 6. MULTI-CONDITION RANGE FILTERING
-- Target: View registrations specifically for Semester 1 of the year 2026.
-- ----------------------------------------------------------------------------
SELECT StudentID, CourseID, Semester, Year
FROM Registration
WHERE Year = 2026
  AND Semester = 'Semester 1';
