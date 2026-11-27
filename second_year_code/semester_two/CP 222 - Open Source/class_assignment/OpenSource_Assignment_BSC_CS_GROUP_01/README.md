# Student Information Management System (SIMS)

## Academic Metadata
* **Degree Program:** Bachelor of Science in Computer Science
* **Group Number:** Group 01
* **Course Code & Title:** CP 222 - Open Source Technologies

---

## 1. Project Overview
The **Student Information Management System (SIMS)** is a lightweight, responsive, and secure full-stack web application designed to digitize student records management in both Primary and Secondary schools within the Tanzanian educational context. 

The system features a modern **Neumorphic UI** design architecture with adaptive Light/Dark mode toggles. It provides administrative functionalities to authenticate users, register new students with specific academic levels (Standard 1-7 or Form 1-6), view dynamic data-driven records, and search for specific profiles using unique registration numbers.

---

## 2. Technologies Used
This project is built using core open-source web technologies to guarantee high performance and scalability:
* **Backend:** PHP 8.2 (Using secure PDO - PHP Data Objects)
* **Database:** MySQL (Relational Database Management System)
* **Frontend UI:** Vanilla HTML5, Modern CSS3 (Neumorphic Styling), and JavaScript (ES6+ for theme toggling and DOM manipulation)
* **Icons:** FontAwesome v6.4.0 (CDN)
* **Version Control:** Git & GitHub

---

## 3. Installation Steps & Dependencies

### Prerequisites
* **XAMPP Server** (PHP 8.x, Apache, and MySQL) Installed.
* **Git Bash** terminal configured.

### Local Deployment Setup
Follow these steps to set up and run the project locally on your machine:

1.  **Clone the Repository:**
    Open Git Bash, navigate to your XAMPP local server directory, and clone this repository:
    ```bash
    cd C:/xampp/htdocs
    git clone [https://github.com/expertmib/OpenSource_Assignment_BSC_CS_GROUP_01.git](https://github.com/expertmib/OpenSource_Assignment_BSC_CS_GROUP_01.git) sims-project
    ```
2.  **Database Configuration:**
    * Open your browser and navigate to `http://localhost/phpmyadmin/`.
    * Create a new database named `sims_db`.
    * Import the SQL database schema file located at `sims-project/config/school.sql`.
3.  **Configure Environment:**
    Ensure database access credentials match your XAMPP local server environment inside `config/db.php`.
4.  **Launch the Application:**
    * Start **Apache** and **MySQL** modules from your XAMPP Control Panel.
    * Open your browser and access the secure portal via: `http://localhost/sims-project/login.php`

> 🔑 **Default Admin Credentials:**
> * **Email:** `admin@sims.ac.tz`
> * **Password:** `admin123`

---

## 4. Git Commands Used
Throughout the system development life cycle, standard Git workflow commands were strictly utilized for version control and branch architecture maintenance:

* `git init` - Initialized the local repository.
* `git branch development` - Created an isolated environment for writing code features.
* `git checkout <branch-name>` - Switched context between development and main branches.
* `git status` - Tracked modified, staged, and untracked repository files.
* `git add <file_path>` - Staged specific software modifications before tracking.
* `git commit -m "commit message"` - Recorded staged snapshots with descriptive messages.
* `git log --oneline` - Monitored commit history timelines.
* `git merge development` - Unified tested software updates into the production main branch.
* `git push origin main` - Transferred local software milestones safely to GitHub.

---

## 5. GitHub Repository Link
The entire source code, issue resolution timeline, and detailed commit history can be physically verified on the official cloud hub repository:

🔗 **GitHub Repository:** [https://github.com/expertmib/OpenSource_Assignment_BSC_CS_GROUP_01.git](https://github.com/expertmib/OpenSource_Assignment_BSC_CS_GROUP_01.git)

***
*Developed as a Computer Science Group Assignment for Open Source Technologies Module.*