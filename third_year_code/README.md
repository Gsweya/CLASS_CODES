# Third Year Code

Coursework for the third year, organised by semester and course.

```
third_year_code/
├── .gitignore
├── README.md
└── semester_one/
    ├── CP 311 - Internet Programming and Applications II/
    │   ├── ASSIGNMENT_1/               # XML Student Information System (group assignment)
    │   │   ├── students.xml            # student records + internal DTD
    │   │   ├── students.php            # SimpleXML program that displays the records
    │   │   ├── students_output.html    # saved output of students.php
    │   │   ├── README.md               # Task 4: XML data exchange explanation
    │   │   └── GUIDELINE.md            # full assignment guide (running, validating, presenting)
    │   ├── ASSIGNMENT_2/               # Lab Work (Week 5): Student Management System in PHP OOP (question_a-f)
    │   ├── class_session/              # OOP in PHP lessons (01-07) + CLAUDE_SUMMARIES study guide
    │   └── PRACTICE/coffee_shop/       # practice web app: OOP + XML (SimpleXML, DOM, XPath, XSD, XSLT, XMLWriter)
    └── CP 313 - Mobile Application Development/
        ├── README.md               # course index
        └── shiri/                  # Android Studio project (Java)
```

## Semester one

| Course | Title | Work | Stack | Start here |
|--------|-------|------|-------|------------|
| CP 311 | Internet Programming and Applications II | XML Student Information System (group assignment) | XML, DTD, PHP (SimpleXML) | [ASSIGNMENT_1/GUIDELINE.md](semester_one/CP%20311%20-%20Internet%20Programming%20and%20Applications%20II/ASSIGNMENT_1/GUIDELINE.md) |
| CP 311 | Internet Programming and Applications II | Lab Work (Week 5): Student Management System | PHP 8 OOP | [ASSIGNMENT_2/question_f.php](semester_one/CP%20311%20-%20Internet%20Programming%20and%20Applications%20II/ASSIGNMENT_2/question_f.php) |
| CP 311 | Internet Programming and Applications II | OOP in PHP class session | PHP 8 | [class_session/README.md](semester_one/CP%20311%20-%20Internet%20Programming%20and%20Applications%20II/class_session/README.md) |
| CP 311 | Internet Programming and Applications II | Coffee shop practice app + exercises | PHP 8 OOP, XML, XSD, XSLT | [PRACTICE/coffee_shop/README.md](semester_one/CP%20311%20-%20Internet%20Programming%20and%20Applications%20II/PRACTICE/coffee_shop/README.md) |
| CP 313 | Mobile Application Development | `shiri`: student registration form app | Android, Java, Gradle (Kotlin DSL) | [shiri/README.md](semester_one/CP%20313%20-%20Mobile%20Application%20Development/shiri/README.md) |

## Quick start

### CP 311 (PHP + XML)

```bash
cd "third_year_code/semester_one/CP 311 - Internet Programming and Applications II/ASSIGNMENT_1"
php -S localhost:8000
# open http://localhost:8000/students.php
```

Validate the XML against its DTD:

```bash
xmllint --noout --valid students.xml
```

XAMPP instructions are in `ASSIGNMENT_1/GUIDELINE.md`.

OOP lessons: `cd class_session && php 01_objects.php` (see `class_session/README.md`).

### CP 313 (Android)

Open the `shiri/` folder (not the course folder) in Android Studio, or build from the terminal:

```bash
cd "third_year_code/semester_one/CP 313 - Mobile Application Development/shiri"
./gradlew assembleDebug
```

Full setup is in [`shiri/README.md`](semester_one/CP%20313%20-%20Mobile%20Application%20Development/shiri/README.md).

## Adding new work

1. Create the course folder if it does not exist: `semester_<n>/<CODE> - <Course Name>/`.
2. Put each assignment, lab or project in its own subfolder.
3. Add a short `README.md` to anything that needs setup steps to run.
4. Run `git status` before committing and make sure no `build/`, `.gradle/`, `.idea/` or `local.properties` files are listed.
