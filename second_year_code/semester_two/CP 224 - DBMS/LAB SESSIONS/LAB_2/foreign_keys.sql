-- ============================================================================
-- SQL FOREIGN KEY RELATIONSHIPS AND DELETE BEHAVIORS DEMO
-- ============================================================================

-- ----------------------------------------------------------------------------
-- SCENARIO 1: ONE-TO-MANY WITH 'ON DELETE CASCADE'
-- Business Rule: One department has many employees.
-- If a department is deleted, all its employees are automatically deleted.
-- ----------------------------------------------------------------------------

-- 1a. Create Parent Table
CREATE TABLE departments (
    department_id INT PRIMARY KEY,
    department_name VARCHAR(50) NOT NULL
);

-- 1b. Create Child Table
CREATE TABLE employees (
    employee_id INT PRIMARY KEY,
    employee_name VARCHAR(50) NOT NULL,
    dept_id INT, -- Stores the reference to the departments table

    CONSTRAINT fk_employee_department
        FOREIGN KEY (dept_id)             -- Column in this table
        REFERENCES departments(department_id) -- Target table and column
        ON DELETE CASCADE                 -- Automatically removes employees if their department is deleted
);


-- ----------------------------------------------------------------------------
-- SCENARIO 2: ONE-TO-MANY WITH 'ON DELETE SET NULL'
-- Business Rule: One manager has many team members.
-- If a manager leaves, we want to keep the employees but empty their manager field.
-- ----------------------------------------------------------------------------

-- 2a. Create Parent Table
CREATE TABLE managers (
    manager_id INT PRIMARY KEY,
    manager_name VARCHAR(50) NOT NULL
);

-- 2b. Create Child Table
CREATE TABLE team_members (
    member_id INT PRIMARY KEY,
    member_name VARCHAR(50) NOT NULL,
    mngr_id INT, -- Must allow NULL values for SET NULL to work

    CONSTRAINT fk_team_manager
        FOREIGN KEY (mngr_id)
        REFERENCES managers(manager_id)
        ON DELETE SET NULL                -- Retains the team member row but sets mngr_id to NULL if manager is deleted
);


-- ----------------------------------------------------------------------------
-- SCENARIO 3: ONE-TO-ONE RELATIONSHIP (USING UNIQUE CONSTRAINT)
-- Business Rule: One user has exactly one profile.
-- Adding 'UNIQUE' to the foreign key guarantees it remains a 1-to-1 relationship.
-- ----------------------------------------------------------------------------

-- 3a. Create Parent Table
CREATE TABLE users (
    user_id INT PRIMARY KEY,
    username VARCHAR(30) NOT NULL
);

-- 3b. Create Child Table
CREATE TABLE user_profiles (
    profile_id INT PRIMARY KEY,
    bio TEXT,
    usr_id INT UNIQUE, -- UNIQUE keyword enforces exactly one profile per user

    CONSTRAINT fk_profile_user
        FOREIGN KEY (usr_id)
        REFERENCES users(user_id)
        ON DELETE CASCADE                 -- Deletes the profile automatically if the user is deleted
);


-- ----------------------------------------------------------------------------
-- SCENARIO 4: MANY-TO-MANY RELATIONSHIP (USING A JUNCTION TABLE)
-- Business Rule: Students can take many courses. Courses can have many students.
-- Requires a third table to bridge the relationship using two foreign keys.
-- ----------------------------------------------------------------------------

-- 4a. Create First Main Table
CREATE TABLE students (
    student_id INT PRIMARY KEY,
    student_name VARCHAR(50) NOT NULL
);

-- 4b. Create Second Main Table
CREATE TABLE courses (
    course_id INT PRIMARY KEY,
    course_title VARCHAR(50) NOT NULL
);

-- 4c. Create Junction Table
CREATE TABLE student_courses (
    std_id INT,
    crs_id INT,

    -- Composite Primary Key prevents a student from enrolling in the exact same course twice
    PRIMARY KEY (std_id, crs_id),

    -- Link to students table
    CONSTRAINT fk_junction_student
        FOREIGN KEY (std_id)
        REFERENCES students(student_id)
        ON DELETE CASCADE,                -- Unenrolls student from course if student account is deleted

    -- Link to courses table
    CONSTRAINT fk_junction_course
        FOREIGN KEY (crs_id)
        REFERENCES courses(course_id)
        ON DELETE CASCADE                 -- Unenrolls everyone from this course if the course is deleted
);


-- ============================================================================
-- SUMMARY OF CONSTRAINT PARAMETERS
-- ============================================================================
-- * FOREIGN KEY (col): Declares the local tracking column.
-- * REFERENCES tbl(col): Names the external target table and primary key.
-- * ON DELETE CASCADE: Purges child data when parent data dies.
-- * ON DELETE SET NULL: Clears out references but preserves child rows.
-- ============================================================================
