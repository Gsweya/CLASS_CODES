/* Altering the table to add columns */

ALTER TABLE students
ADD COLUMN contact VARCHAR(30),
ADD COLUMN address VARCHAR(30);

INSERT INTO students (full_name, gender, age, course, contact, address)
VALUES ("James Logodya", "M", 20, "BSC-CS", "0713532934", "Dodoma, Longido"),
("Halusa Makamya", "M", 20, "BSC-SE", "0713532934", "Singida, Longido"),
("Mkawiso Menda", "M", 20, "BSC-BIS", "0713532934", "Dodoma, Logoya"),
("Sara Malende", "F", 20, "BSC-CSDFE", "0713392934", "Mwanza, Wosi"),
("Diana Rilisho", "F", 20, "BSC-MTA", "073432934", "Zanzibar, Yeriko");


UPDATE students
SET contact = "0713532938"
WHERE full_name = "Amon Toroto";

UPDATE students
SET address = "Bombo, Mwanza"
WHERE address IS NULL;
DELETE FROM students
WHERE student_id=14;


CREATE TABLE courses (
    course_id INT AUTO_INCREMENT PRIMARY KEY,
    course_name VARCHAR(50) NOT NULL
);


CREATE TABLE enrollment (
    enrollment_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    course_id INT,
    FOREIGN KEY (student_id) REFERENCES students(student_id),
    FOREIGN KEY (course_id) REFERENCES courses(course_id)

);


CREATE TABLE COURSES(
    id INT PRIMARY KEY AUTO_INCREMENT,
    dept_name VARCHAR(20) UNIQUE
);


INSERT INTO courses (course_name)
VALUES (""),
("IS"),
("ICT");

RENAME TABLE deptartment TO departments;
