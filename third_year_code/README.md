# Third Year Code

Coursework for the third year, organised by semester and course.

```
third_year_code/
├── .gitignore
├── README.md
└── semester_one/
    ├── CP 311 - Internet Programming and Applications II/
    │   ├── students.xml            # student records + internal DTD
    │   ├── students.php            # SimpleXML program that displays the records
    │   ├── students_output.html    # saved output of students.php
    │   ├── README.md               # Task 4: XML data exchange explanation
    │   └── GUIDELINE.md            # full assignment guide (running, validating, presenting)
    └── CP 313 - Mobile Application Development/
        ├── README.md               # course index
        └── shiri/                  # Android Studio project (Java)
```

## Semester one

| Course | Title | Work | Stack | Start here |
|--------|-------|------|-------|------------|
| CP 311 | Internet Programming and Applications II | XML Student Information System (group assignment) | XML, DTD, PHP (SimpleXML) | [GUIDELINE.md](semester_one/CP%20311%20-%20Internet%20Programming%20and%20Applications%20II/GUIDELINE.md) |
| CP 313 | Mobile Application Development | `shiri`: student registration form app | Android, Java, Gradle (Kotlin DSL) | [shiri/README.md](semester_one/CP%20313%20-%20Mobile%20Application%20Development/shiri/README.md) |

## Quick start

### CP 311 (PHP + XML)

```bash
cd "third_year_code/semester_one/CP 311 - Internet Programming and Applications II"
php -S localhost:8000
# open http://localhost:8000/students.php
```

Validate the XML against its DTD:

```bash
xmllint --noout --valid students.xml
```

XAMPP instructions are in `GUIDELINE.md`.

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
